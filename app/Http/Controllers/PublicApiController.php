<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

            if (!empty($user?->email_verified_at) && Hash::check($request->post('password'), $user?->password)) {
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

            if (!empty($user?->email_verified_at) && $user?->api_token === $data['client_token']) {
                return new UserResource($user);
            }
        }

        return response()->json(new ErrorResource('Unauthenticated.'), 401);
    }
}
