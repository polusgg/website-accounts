<?php

namespace App\Providers;

use Socialite;
use App\Socialite\DiscordSocialiteProvider;
use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Socialite::extend('discord', function ($app) {
            $config = $app['config']['services.discord'];

            return Socialite::buildProvider(DiscordSocialiteProvider::class, $config);
        });
    }
}
