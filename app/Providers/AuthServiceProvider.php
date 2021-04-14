<?php

namespace App\Providers;

use App\Models\User;
use App\Models\PrivateToken;
use Auth;
use Hash;
use Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('token-private', function (Request $request) {
            return PrivateToken::where('token', $request->bearerToken())->first();
        });

        Auth::viaRequest('token-user', function (Request $request) {
            if (!$request->hasHeader('Client-ID')) {
                return null;
            }

            $uuid = $request->header('Client-ID');

            if (!Str::isUuid($uuid)) {
                return null;
            }

            return User::where('uuid', $uuid)->where('api_token', $request->bearerToken())->first();
        });

        // Auth::viaRequest('credentials-user', function (Request $request) {
        //     if (!$request->hasHeader('Email')) {
        //         return null;
        //     }

        //     $email = $request->header('Email');
        //     $user = User::where('email', $email)->first();

        //     if (is_null($user)) {
        //         return null;
        //     }

        //     if (Hash::check($request->bearerToken(), $user->password)) {
        //         return $user;
        //     }

        //     return null;
        // });
    }
}
