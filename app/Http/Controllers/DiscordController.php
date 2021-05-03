<?php

namespace App\Http\Controllers;

use App\Discord\Discord;
use App\Models\DiscordRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        if (!empty($request->query('error'))) {
            return redirect()->route('profile.show');
        }

        $user = auth()->user();
        $discord = Socialite::driver('discord')->user();

        if (User::where('discord_snowflake', $discord->id)->where('id', '!=', $user->id)->exists()) {
            $bag = new ViewErrorBag();
            $errors = new MessageBag();

            $errors->add('discord_login', 'Another user has already connected that Discord account');
            $bag->put('default', $errors);
            session()->flash('errors', $bag);

            return redirect()->route('profile.show');
        }

        $discordRoles = DiscordRole::all();
        $roles = app(Discord::class)->getRoles($discord->id);

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

        if ($user->is_discord_connected) {
            app(Discord::class)->joinGuild($user->discord_snowflake, $user->discord_token);
        }

        return redirect()->back();
    }
}
