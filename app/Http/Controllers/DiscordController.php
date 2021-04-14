<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discord\Discord;
use App\Models\DiscordRole;
use App\Models\User;
use Socialite;
use Carbon\Carbon;

class DiscordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        if (!empty($request->query('error'))) {
            return redirect()->route('profile.show');
        }

        $discord = Socialite::driver('discord')->user();

        // TODO:
        // 1. Error handling and HTTP code checks
        // 2. Check if a user already has the given Discord account connected
        // $user = User::firstOrFail(['discord_snowflake' => $discord->id]);

        $discordRoles = DiscordRole::all();
        $roles = app(Discord::class)->getRoles($discord->id);
        $user = auth()->user();

        $user->discord_snowflake = $discord->id;
        $user->discord_token = $discord->token;
        $user->discord_refresh_token = $discord->refreshToken;
        $user->discord_expires_at = Carbon::now()->addSeconds($discord->expiresIn);

        $userRoles = $discordRoles->filter(
            fn($role) =>
                $roles->contains($role->role_snowflake) ||
                ($user->is_creator && $role->role_snowflake == config('services.discord.creator_role_id'))
        );

        $user->discordRoles()->sync($userRoles);

        $user->save();

        return redirect()->route('profile.show');
    }

    public function joinServer()
    {
        $user = auth()->user();

        if (isset($user->discord_token)) {
            app(Discord::class)->joinGuild($user->discord_snowflake, $user->discord_token);
        }

        return redirect()->back();
    }
}
