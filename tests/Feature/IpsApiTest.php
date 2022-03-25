<?php

namespace OvaStudio\IpsApi\Tests\Feature;

use OvaStudio\IpsApi\Exceptions\PermissionException;
use OvaStudio\IpsApi\Exceptions\ServerException;
use OvaStudio\IpsApi\Exceptions\TokenException;
use OvaStudio\IpsApi\IpsApi;
use OvaStudio\IpsApi\Tests\TestCase;

class IpsApiTest extends TestCase
{
    public function test_api_hello()
    {
        $response = (new IpsApi())->client->get('core/hello');

        self::assertEquals(200, $response->getStatusCode());
    }

    public function test_api_server_exception()
    {
        config([ 'services.ips.base_uri' => 'https://ova.in.ua' ]);
        $this->expectException(ServerException::class);

        (new IpsApi())->client->get('core/hello');
    }

    public function test_api_token_exception()
    {
        $this->expectException(TokenException::class);

        (new IpsApi())->withApiKey('')->client->get('core/hello');
    }

    public function test_api_permission_exception()
    {
        $this->expectException(PermissionException::class);

        (new IpsApi())->client->get('core/me');
    }
}
