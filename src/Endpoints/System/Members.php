<?php

namespace OvaStudio\IpsApi\Endpoints\System;

use OvaStudio\IpsApi\Endpoints\AbstractEndpoint;

class Members extends AbstractEndpoint
{
    private const ENDPOINT = 'core/members';

    /**
     * @param array<string> $filters - filtering results [ 'name' => string, 'email' => string, 'group' => int|array ]
     * @param string $order_by - 'joined', 'name' or 'last_activity'
     * @param string $order_dir - 'asc' or 'desc'
     */
    public function index(array $filters = [], string $order_by = 'name', string $order_dir = 'asc')
    {
        $query = [];

        if (!empty($filters['name']))
            $query['name'] = $filters['name'];

        if (!empty($filters['email']))
            $query['email'] = $filters['email'];

        if (!empty($filters['group']))
            $query['group'] = $filters['group'];

        $query['sortBy'] = $order_by;
        $query['sortDir'] = $order_dir;

        $response = $this->api->client->get(self::ENDPOINT, [ 'query' => $query ]);

        return json_decode($response->getBody());
    }

    public function view(int $member_id)
    {
        $response = $this->api->client->get(self::ENDPOINT . '/' . $member_id);

        return json_decode($response->getBody());
    }

    /**
     * @param int $member_id
     * @param array $data
     */
    public function update(int $member_id, array $data) : void
    {
        $this->api->client->post(self::ENDPOINT . '/' . $member_id, [
            'form_params' => $data
        ]);
    }

    public function achieve(int $member_id, int $badge_id) : void
    {
        $this->api->client->post(self::ENDPOINT . '/' . $member_id . '/achievements/' . $badge_id . '/awardbadge');
    }
}
