<?php

use App\Http\Controllers\PrivateApiController;
use App\Http\Resources\ErrorResource;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api-private')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('{user}', [PrivateApiController::class, 'getUser'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::get('discord/{user:discord_snowflake}', [PrivateApiController::class, 'getUser'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::post('discord/{user:discord_snowflake}/roles', [PrivateApiController::class, 'updateDiscordRoles'])
            ->missing(fn() => response()->json(new ErrorResource('User not found'), 404));
        Route::put('{user}/options', [PrivateApiController::class, 'updateGameConfig'])
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
