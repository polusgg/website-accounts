<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    public function getToken(Request $request)
    {
        $email = $request->header('Email');

        if (empty($email)) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        $user = User::where('email', $email)->first();

        if (is_null($user)) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        if (Hash::check($request->bearerToken(), $user->password)) {
            return new SuccessResource([
                'client_id' => $user->uuid,
                'client_token' => $user->api_token,
                'display_name' => $user->display_name,
            ]);
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    }

    public function checkToken(Request $request)
    {
        $clientId = $request->header('Client-ID');

        if (empty($clientId)) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        $user = User::where('uuid', $clientId)->first();

        if (is_null($user)) {
            return response()->json(new ErrorResource('Unauthenticated.'), 401);
        }

        if ($user->token == $request->bearerToken()) {
            return new SuccessResource(['display_name' => $user->display_name]);
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    }
}