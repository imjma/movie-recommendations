<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GuzzleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GuzzleClient', function ($app) {
            return new \GuzzleHttp\Client();
        });
    }
}