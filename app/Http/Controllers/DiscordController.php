<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\MessageBag;
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

        if (User::where('discord_snowflake', $discord->id)->exists()) {
            $bag = new ViewErrorBag();
            $errors = new MessageBag();

            $errors->add('discord_login', 'Another user has already connected that Discord account');
            $bag->put('default', $errors);
            session()->flash('errors', $bag);

            return redirect()->route('profile.show');
        }

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
