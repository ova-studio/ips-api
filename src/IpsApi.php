<?php

namespace OvaStudio\IpsApi;

use Closure;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client;
use OvaStudio\IpsApi\Exceptions\AppUnavailableException;
use OvaStudio\IpsApi\Exceptions\BadRequestException;
use OvaStudio\IpsApi\Exceptions\BannedException;
use OvaStudio\IpsApi\Exceptions\NotFoundException;
use OvaStudio\IpsApi\Exceptions\OAuthException;
use OvaStudio\IpsApi\Exceptions\PermissionException;
use OvaStudio\IpsApi\Exceptions\ServerException;
use OvaStudio\IpsApi\Exceptions\TokenException;
use OvaStudio\IpsApi\Exceptions\TokenExpiredException;
use OvaStudio\IpsApi\Exceptions\UnauthorizedException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IpsApi
{
    private const API_VERSION = '1.0';

    private string $baseUrl;

    private string $authorization;

    public Client $client;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.ips.base_uri'), '/ ') . '/api/';
        $this->withApiKey();

        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        // Request processing
        $stack->push($this->makeRequestProcessing());

        // Response processing
        $stack->push($this->makeResponseProcessing());

        $this->client = new Client(['base_uri' => $this->baseUrl, 'http_errors' => false, 'handler' => $stack]);
    }

    public function withAccessToken(string $accessToken) : static
    {
        $this->authorization = "Bearer $accessToken";

        return $this;
    }

    public function withApiKey(?string $key = null) : static
    {
        if ($key === null)
            $key = config('services.ips.api_key');

        $this->authorization = 'Basic  ' . base64_encode("$key:");

        return $this;
    }

    private function makeResponseProcessing() : Closure
    {
        return function (callable $handler) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {
                $promise = $handler($request, $options);
                return $promise->then(
                    function (ResponseInterface $response) {
                        $statusCode = $response->getStatusCode();

                        if ($statusCode !== 200 and $statusCode !== 201)
                        {
                            $data = json_decode($response->getBody());

                            if (empty($data) || !property_exists($data, 'errorMessage'))
                            {
                                throw new ServerException((string)$statusCode, 'SERVER_ERROR');
                            }

                            /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection */
                            switch ($data->errorMessage)
                            {
                                case 'NO_API_KEY':
                                case 'CANNOT_USE_KEY_AS_URL_PARAM':
                                case 'INVALID_API_KEY':
                                case 'INVALID_ACCESS_TOKEN':
                                    throw new TokenException($data->errorCode, $data->errorMessage);

                                case 'EXPIRED_ACCESS_TOKEN':
                                    throw new TokenExpiredException($data->errorCode, $data->errorMessage);

                                case 'MEMBER_ONLY':
                                case 'CLIENT_ONLY':
                                    throw new OAuthException;

                                case 'IP_ADDRESS_BANNED':
                                case 'TOO_MANY_REQUESTS_WITH_BAD_KEY':
                                    throw new BannedException($data->errorCode, $data->errorMessage);

                                case 'IP_ADDRESS_NOT_ALLOWED':
                                case 'NO_SCOPES':
                                    throw new UnauthorizedException($data->errorCode, $data->errorMessage);

                                case 'NO_PERMISSION':
                                case 'CANNOT_CREATE':
                                    throw new PermissionException($data->errorCode, $data->errorMessage);

                                case 'BAD_METHOD':
                                case 'NO_ENDPOINT':
                                case 'INVALID_CONTROLLER':
                                case 'INVALID_LANGUAGE':
                                case 'NO_USERNAME_OR_EMAIL':
                                case 'INVALID_GROUP':
                                case 'EMAIL_EXISTS':
                                case 'USERNAME_EXISTS':
                                    throw new BadRequestException($data->errorCode, $data->errorMessage);

                                case 'APP_DISABLED':
                                case 'INVALID_APP':
                                    throw new AppUnavailableException($data->errorCode, $data->errorMessage);

                                case 'INVALID_ID':
                                case 'INVALID_MEMBER':
                                case 'INVALID_FOLLOW_KEY':
                                case 'INVALID_WARNING':
                                    throw new NotFoundException($data->errorCode, $data->errorMessage);

                                default:
                                    throw new ServerException($data->errorCode, $data->errorMessage);
                            }
                        }

                        return $response;
                    }
                );
            };
        };
    }

    private function makeRequestProcessing() : Closure
    {
        return function (callable $handler) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {

                $request = $request->withHeader('User-Agent', 'ova-studio-ips-api/' . static::API_VERSION);
                $request = $request->withHeader('Accept', 'application/json');
                $request = $request->withHeader('Authorization', $this->authorization);

                return $handler($request, $options);
            };
        };
    }
}
