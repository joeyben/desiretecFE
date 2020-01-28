<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Api\ApiService;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Api\ApiService', function ($app) {
            return new ApiService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
