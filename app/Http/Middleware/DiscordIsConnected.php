<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DiscordIsConnected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() || empty($request->user()->discord_snowflake)) {
            return $request->expectsJson()
                    ? abort(403, 'You have no connected Discord account.')
                    : redirect()->route($redirectToRoute ?? 'profile.show');
        }

        return $next($request);
    }
}
