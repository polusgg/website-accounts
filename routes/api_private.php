<?php

use App\Http\Controllers\PrivateApiController;
use App\Http\Resources\ErrorResource;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api-private')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('watchlist', [PrivateApiController::class, 'getWatchlist'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('{user}', [PrivateApiController::class, 'getUser'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::patch('{user}/watch', [PrivateApiController::class, 'addToWatchlist'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::delete('{user}/watch', [PrivateApiController::class, 'removeFromWatchlist'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('name/{user:display_name}', [PrivateApiController::class, 'getUser'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('discord/{user:discord_snowflake}', [PrivateApiController::class, 'getUser'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::post('discord/{user:discord_snowflake}/roles', [PrivateApiController::class, 'updateDiscordRoles'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::put('{user}/options', [PrivateApiController::class, 'updateGameConfig'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::patch('update/{user}/name', [PrivateApiController::class, 'updateUserName'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::put('update/{user}/cosmetics', [PrivateApiController::class, 'updateUserCosmetics'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
    });

    Route::prefix('logs')->group(function () {
        Route::put('kick', [PrivateApiController::class, 'logKick']);
        Route::get('kick/{user}/from', [PrivateApiController::class, 'getKicksFrom'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('kick/{user}/against', [PrivateApiController::class, 'getKicksAgainst'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::put('ban', [PrivateApiController::class, 'logBan']);
        Route::get('ban/{user}/from', [PrivateApiController::class, 'getBansFrom'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('ban/{user}/against', [PrivateApiController::class, 'getBansAgainst'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::put('mute', [PrivateApiController::class, 'logMute']);
        Route::get('mute/{user}/from', [PrivateApiController::class, 'getMutesFrom'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('mute/{user}/against', [PrivateApiController::class, 'getMutesAgainst'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
    });
});
