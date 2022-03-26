<?php

namespace OvaStudio\IpsApi\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OvaStudio\IpsApi\IpsApiServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config([ 'services.ips.base_uri' => 'https://forum.zdsimulator.com' ]);
        config([ 'services.ips.default_user' => 5107 ]);

        /** @noinspection LaravelFunctionsInspection */
        config([ 'services.ips.api_key' => env('IPS_API_KEY') ]);
    }

    protected function getPackageProviders($app) : array
    {
        return [
            IpsApiServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
