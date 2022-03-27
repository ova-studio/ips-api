<?php

namespace OvaStudio\IpsApi\Tests\Feature\Endpoints;

use OvaStudio\IpsApi\IpsApi;
use OvaStudio\IpsApi\Tests\TestCase;

class SystemMembersTest extends TestCase
{
    public function test_index()
    {
        $result = (new IpsApi())->system()->members()->index([ 'name' => 'chaker' ]);

        self::assertEquals('chaker', $result->results[0]->name);
    }

    public function test_view()
    {
        $result = (new IpsApi())->system()->members()->view(1);

        self::assertEquals('chaker', $result->name);
    }

    public function test_update()
    {
        $test_name = 'api-client-test';
        $api = (new IpsApi())->system()->members();

        $origData = $api->view(config('services.ips.default_user'));

        $api->update($origData->id, [ 'name' => $test_name ]);

        $editedData = $api->view(config('services.ips.default_user'));

        self::assertEquals($test_name, $editedData->name);

        $api->update($origData->id, [ 'name' => $origData->name ]);

        $editedData = $api->view(config('services.ips.default_user'));

        self::assertEquals($origData->name, $editedData->name);
    }

    public function test_achieve()
    {
        $badgeId = 5;
        $api = (new IpsApi())->system()->members();

        $api->achieve(config('services.ips.default_user'), $badgeId);

        self::assertTrue(true);
    }
}
