<?php

namespace OvaStudio\IpsApi;

use Illuminate\Support\ServiceProvider;

class IpsApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('ips-api', function () {
            return new IpsApi;
        });
    }
}
