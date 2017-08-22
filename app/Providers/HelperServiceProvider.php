<?php

namespace App\Providers;

use App\Helpers\DateTimeHelper;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
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
        $this->app->bind(DateTimeHelper::class, 'App\Helpers\DateTimeHelper');
    }
}