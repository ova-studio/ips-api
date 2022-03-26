<?php

namespace OvaStudio\IpsApi\Endpoints\System;

use OvaStudio\IpsApi\Endpoints\AbstractEndpoint;
use OvaStudio\IpsApi\IpsApi;

class Messages extends AbstractEndpoint
{
    private const ENDPOINT = 'core/messages';

    private int $from;

    public function __construct(IpsApi $api)
    {
        parent::__construct($api);

        $this->withSender(config('services.ips.default_user', 1));
    }

    public function withSender(int $from)
    {
        $this->from = $from;
    }

    public function create(int $to, string $title, string $body) : void
    {
        $this->api->client->post(self::ENDPOINT, [
            'form_params' => [
                'from' => $this->from,
                'to' => [ $to ],
                'title' => $title,
                'body' => $body
            ]
        ]);
    }



}
