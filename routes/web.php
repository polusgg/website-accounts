<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiscordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('discord')->group(function () {
    Route::middleware(['discord.no'])->group(function () {
        Route::get('redirect', [DiscordController::class, 'redirectToProvider'])
            ->name('discord.connect');
        Route::get('callback', [DiscordController::class, 'handleProviderCallback']);
    });
    Route::middleware(['discord.yes'])->group(function () {
        Route::get('join', [DiscordController::class, 'joinServer'])
            ->name('discord.join');
    });
});
