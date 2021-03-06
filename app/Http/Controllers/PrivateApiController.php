<?php

namespace App\Http\Controllers;

use App\Discord\Discord;
use App\Models\DiscordRole;
use App\Models\GameConfig;
use App\Models\KickBanLog;
use App\Models\GameMute;
use App\Models\User;
use App\Rules\NotOffensive;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PrivateApiController extends Controller
{
    public function getWatchlist()
    {
        return new UserCollection(User::where('watchlisted', true)->get());
    }

    public function getUser(User $user)
    {
        return new UserResource($user);
    }

    public function addToWatchlist(User $user)
    {
        $user->watchlisted = true;

        if ($user->save()) {
            return new SuccessResource();
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }

    public function removeFromWatchlist(User $user)
    {
        $user->watchlisted = false;

        if ($user->save()) {
            return new SuccessResource();
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }

    public function getKicksFrom(User $user)
    {
        return $user->kicksFrom()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function getKicksAgainst(User $user)
    {
        return $user->kicksAgainst()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function getBansFrom(User $user)
    {
        return $user->bansFrom()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function getBansAgainst(User $user)
    {
        return $user->bansAgainst()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function getMutesFrom(User $user)
    {
        return $user->mutesFrom()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function getMutesAgainst(User $user)
    {
        return $user->mutesAgainst()->with([
            'actingUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
            'targetUser' => function ($q) {
                $q->select('id', 'uuid', 'display_name');
            },
        ])->orderByDesc('id')->paginate(15);
    }

    public function updateDiscordRoles(User $user)
    {
        $discordRoles = DiscordRole::all();
        $roles = app(Discord::class)->getRoles($user->discord_snowflake);

        $userRoles = $discordRoles->filter(
            fn($role) =>
                $roles->contains($role->role_snowflake) ||
                ($user->is_creator && $role->role_snowflake == config('services.discord.creator_role_id'))
        );

        $user->discordRoles()->sync($userRoles);

        return new SuccessResource();
    }

    public function updateGameConfig(User $user, Request $request)
    {
        $user->gameConfig()->updateOrCreate(['user_id' => $user->id], ['config' => $request->json()->all()]);

        return new SuccessResource();
    }

    public function updateUserName(User $user, Request $request)
    {
        $validated = $request->validate([
            'display_name' => [
                'required',
                'string',
                'between:3,16',
                'regex:/^[ 0-9a-zA-Z\x{00c0}-\x{00ff}\x{0400}-\x{045f}\x{3131}-\x{318e}\x{ac00}-\x{d7a3}]{3,16}$/u',
                'not_regex:/^' . config('app.blocked_names') . '$/i',
                Rule::unique('users')->ignore($user->id),
                new NotOffensive('display name', 'names'),
            ],
        ]);

        $user->display_name = $validated['display_name'];

        if ($user->save()) {
            return new SuccessResource();
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }

    public function updateUserCosmetics(User $user, Request $request)
    {
        $user->cosmeticConfig()->updateOrCreate(['user_id' => $user->id], ['config' => $request->json()->all()]);

        return new SuccessResource();
    }

    public function logKick(Request $request)
    {
        if (!$request->has('game_uuid')) {
            return response()->json(new ErrorResource('Missing game_uuid'), 400);
        }

        $gameUuid = $request->post('game_uuid');

        if (!is_null($gameUuid) && !Str::isUuid($gameUuid)) {
            return response()->json(new ErrorResource('Invalid game_uuid'), 400);
        }

        $actorUuid = $request->post('actor_uuid');

        if (!Str::isUuid($actorUuid)) {
            return response()->json(new ErrorResource('Missing or invalid actor_uuid'), 400);
        }

        $targetUuid = $request->post('target_uuid');

        if (!Str::isUuid($targetUuid)) {
            return response()->json(new ErrorResource('Missing or invalid target_uuid'), 400);
        }

        if (!$request->filled('reason')) {
            return response()->json(new ErrorResource('Missing reason'), 400);
        }

        $actor = User::where('uuid', $actorUuid)->first();
        $target = User::where('uuid', $targetUuid)->first();

        if (is_null($actor)) {
            return response()->json(new ErrorResource('Actor does not exist'), 400);
        }

        if (is_null($target)) {
            return response()->json(new ErrorResource('Target does not exist'), 400);
        }

        $log = new KickBanLog();

        $log->game_uuid = $gameUuid;
        $log->reason = $request->post('reason');

        $log->actingUser()->associate($actor);
        $log->targetUser()->associate($target);

        if ($log->save()) {
            return new SuccessResource();
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }

    public function logBan(Request $request)
    {
        if (!$request->has('game_uuid')) {
            return response()->json(new ErrorResource('Missing game_uuid'), 400);
        }

        $gameUuid = $request->post('game_uuid');

        if (!is_null($gameUuid) && !Str::isUuid($gameUuid)) {
            return response()->json(new ErrorResource('Invalid game_uuid'), 400);
        }

        $actorUuid = $request->post('actor_uuid');

        if (!Str::isUuid($actorUuid)) {
            return response()->json(new ErrorResource('Missing or invalid actor_uuid'), 400);
        }

        $targetUuid = $request->post('target_uuid');

        if (!Str::isUuid($targetUuid)) {
            return response()->json(new ErrorResource('Missing or invalid target_uuid'), 400);
        }

        if (!$request->filled('reason')) {
            return response()->json(new ErrorResource('Missing reason'), 400);
        }

        if (!$request->has('duration')) {
            return response()->json(new ErrorResource('Missing duration'), 400);
        }

        $durationRaw = $request->post('duration');
        $hours = null;

        if (!is_null($durationRaw)) {
            $hours = 1;
            $duration = Str::of($durationRaw)->match('/([1-9][0-9]*[w|d|h]?)/i');

            if ($duration->isEmpty()) {
                return response()->json(new ErrorResource('Invalid duration format'), 400);
            }

            switch ($duration->substr(-1)) {
                case 'w':
                    $hours *= 7;
                    // fallthrough
                case 'd':
                    $hours *= 24;
                    // fallthrough
                case 'h':
                    $duration = $duration->substr(0, -1);
                    // fallthrough
                default:
                    $hours *= (int) (string) $duration;
            }
        }

        $actor = User::where('uuid', $actorUuid)->first();

        if (is_null($actor)) {
            return response()->json(new ErrorResource('Actor does not exist'), 400);
        }

        $target = User::where('uuid', $targetUuid)->first();

        if (is_null($target)) {
            return response()->json(new ErrorResource('Target does not exist'), 400);
        }

        $log = new KickBanLog();

        $log->game_uuid = $gameUuid;
        $log->is_ban = true;
        $log->banned_until = is_null($hours) ? null : Carbon::now()->addHours($hours);
        $log->reason = $request->post('reason');

        $log->actingUser()->associate($actor);
        $log->targetUser()->associate($target);

        if ($log->save()) {
            return new SuccessResource(['duration_hours' => $hours ?? -1]);
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }

    public function logMute(Request $request)
    {
        if (!$request->has('game_uuid')) {
            return response()->json(new ErrorResource('Missing game_uuid'), 400);
        }

        $gameUuid = $request->post('game_uuid');

        if (!is_null($gameUuid) && !Str::isUuid($gameUuid)) {
            return response()->json(new ErrorResource('Invalid game_uuid'), 400);
        }

        $actorUuid = $request->post('actor_uuid');

        if (!Str::isUuid($actorUuid)) {
            return response()->json(new ErrorResource('Missing or invalid actor_uuid'), 400);
        }

        $targetUuid = $request->post('target_uuid');

        if (!Str::isUuid($targetUuid)) {
            return response()->json(new ErrorResource('Missing or invalid target_uuid'), 400);
        }

        if (!$request->filled('reason')) {
            return response()->json(new ErrorResource('Missing reason'), 400);
        }

        if (!$request->has('duration')) {
            return response()->json(new ErrorResource('Missing duration'), 400);
        }

        $durationRaw = $request->post('duration');
        $hours = null;

        if (!is_null($durationRaw)) {
            $hours = 1;
            $duration = Str::of($durationRaw)->match('/([1-9][0-9]*[w|d|h]?)/i');

            if ($duration->isEmpty()) {
                return response()->json(new ErrorResource('Invalid duration format'), 400);
            }

            switch ($duration->substr(-1)) {
                case 'w':
                    $hours *= 7;
                    // fallthrough
                case 'd':
                    $hours *= 24;
                    // fallthrough
                case 'h':
                    $duration = $duration->substr(0, -1);
                    // fallthrough
                default:
                    $hours *= (int) (string) $duration;
            }
        }

        $actor = User::where('uuid', $actorUuid)->first();

        if (is_null($actor)) {
            return response()->json(new ErrorResource('Actor does not exist'), 400);
        }

        $target = User::where('uuid', $targetUuid)->first();

        if (is_null($target)) {
            return response()->json(new ErrorResource('Target does not exist'), 400);
        }

        $log = new GameMute();

        $log->game_uuid = $gameUuid;
        $log->muted_until = is_null($hours) ? null : Carbon::now()->addHours($hours);
        $log->reason = $request->post('reason');

        $log->actingUser()->associate($actor);
        $log->targetUser()->associate($target);

        if ($log->save()) {
            return new SuccessResource(['duration_hours' => $hours ?? -1]);
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }
}
