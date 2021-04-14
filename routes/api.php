<?php

use App\Models\User;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['login-api'])->prefix('v1')->group(function () {
    Route::post('log-in', function (Request $request) {
        if (!$request->hasHeader('Email')) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        $email = $request->header('Email');
        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        if (Hash::check($request->bearerToken(), $user->password)) {
            return new SuccessResource([
                'client_id' => $user->uuid,
                'client_token' => $user->api_token,
            ]);
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    });
    // })->middleware('auth:login-user');
});
