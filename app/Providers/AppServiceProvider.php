<?php

namespace App\Providers;

use App\ApiUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Modules\Languages\Providers\LanguagesServiceProvider;
use Modules\Translations\Providers\TranslationsServiceProvider;

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

        $this->app->register(TranslationsServiceProvider::class);
        $this->app->register(LanguagesServiceProvider::class);
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
