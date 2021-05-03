<?php

namespace App\Providers;

use App\Discord\Discord;
use App\Actions\UpdatesUserConfigInformation;
use App\Actions\UpdateUserConfigInformation;
use Illuminate\Support\Facades\URL;
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
