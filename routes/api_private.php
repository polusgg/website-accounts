<?php

use App\Http\Controllers\PrivateApiController;
use App\Http\Resources\ErrorResource;
use Illuminate\Support\Facades\Route;

function userNotFound()
{
    return response()->json(new ErrorResource('User not found'), 404);
}

Route::middleware('auth:api-private')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('{user}', [PrivateApiController::class, 'getUser'])
            ->missing('userNotFound');
        Route::post('{user:discord_snowflake}/roles', [PrivateApiController::class, 'updateDiscordRoles'])
            ->missing('userNotFound');
    });

    Route::prefix('logs')->group(function () {
        Route::put('kick', [PrivateApiController::class, 'logKick']);
        Route::put('ban', [PrivateApiController::class, 'logBan']);
    });
});
