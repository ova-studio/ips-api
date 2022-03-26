<?php

namespace OvaStudio\IpsApi\Endpoints;

use OvaStudio\IpsApi\IpsApi;
use Psr\Http\Message\ResponseInterface;
use stdClass;

abstract class AbstractEndpoint
{
    protected IpsApi $api;

    public function __construct(IpsApi $api)
    {
        $this->api = $api;
    }

    protected function processResponse(ResponseInterface $response) : stdClass
    {
        return json_decode($response->getBody());
    }
}
