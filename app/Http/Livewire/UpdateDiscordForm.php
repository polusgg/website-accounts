<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use App\Discord\Discord;
use App\Models\User;
use Livewire\Component;
use Socialite;

class UpdateDiscordForm extends Component
{
    public $confirmingDiscordDisconnection = false;

    public function joinDiscord()
    {
        return redirect()->route('discord.join');
    }

    public function confirmDiscordDisconnection()
    {
        $this->dispatchBrowserEvent('confirming-disconnect-discord');

        $this->confirmingDiscordDisconnection = true;
    }

    public function disconnectDiscord(Request $request)
    {
        $user = auth()->user();

        $user->discord_snowflake = null;
        $user->discord_token = null;
        $user->discord_refresh_token = null;
        $user->discord_expires_at = null;

        $roles = $user->discordRoles->filter(fn($role) => !($user->is_creator && $role->role_snowflake == config('services.discord.creator_role_id')));

        $user->discordRoles()->detach($roles);

        $user->save();

        return redirect()->route('profile.show');
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('profile.update-discord-form');
    }
}
