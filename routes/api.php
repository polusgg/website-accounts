<?php

use App\Http\Controllers\PublicApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['login-api'])->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('token', [PublicApiController::class, 'getToken']);// })->middleware('auth:login-user');
        Route::post('check', [PublicApiController::class, 'checkToken']);
    });
});
