<?php

namespace App\Providers;

use App\ApiUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('user', static function (): ? ApiUser {
            return Auth::user();
        });

        $this->app->bind('token', static function (): ?string {
            return session('token');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
