<?php

namespace App\Providers;

use URL;
use App\Discord\Discord;
use Illuminate\Support\ServiceProvider;
use App\Actions\UpdatesUserConfigInformation;
use App\Actions\UpdateUserConfigInformation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(Discord::class)
                  ->needs('$botToken')
                  ->giveConfig('services.discord.bot_token');

        $this->app->when(Discord::class)
                  ->needs('$guildId')
                  ->giveConfig('services.discord.guild_id');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');

        app()->singleton(UpdatesUserConfigInformation::class, UpdateUserConfigInformation::class);
    }
}
