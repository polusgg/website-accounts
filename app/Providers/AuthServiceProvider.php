<?php

namespace App\Providers;

use App\Models\PrivateToken;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    }
}
