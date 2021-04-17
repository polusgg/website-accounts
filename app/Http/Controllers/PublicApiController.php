<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\ErrorResource;
use Hash;
use Validator;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    public function getToken(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->post('email'))->first();

            if (Hash::check($request->post('password'), $user?->password)) {
                return new UserResource($user);
            }
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    }

    public function checkToken(Request $request)
    {
        $data = [
            'client_id' => $request->header('Client-ID'),
            'client_token' => $request->bearerToken(),
        ];

        $validator = Validator::make($data, [
            'client_id' => ['required', 'string', 'uuid'],
            'client_token' => ['required', 'string'],
        ]);

        if (!$validator->fails()) {
            $user = User::where('uuid', $data['client_id'])->first();

            if ($user?->api_token === $data['client_token']) {
                return new UserResource($user);
            }
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    }
}
