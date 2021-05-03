<?php

namespace App\Http\Controllers;

use App\Discord\Discord;
use App\Models\DiscordRole;
use App\Models\KickBanLog;
use App\Models\User;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrivateApiController extends Controller
{
    public function getUser(User $user)
    {
        return new UserResource($user);
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

    public function logKick(Request $request)
    {
        $gameUuid = $request->post('game_uuid');

        if (!Str::isUuid($gameUuid)) {
            return response()->json(new ErrorResource('Missing or invalid game_uuid'), 400);
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
        $gameUuid = $request->post('game_uuid');

        if (!Str::isUuid($gameUuid)) {
            return response()->json(new ErrorResource('Missing or invalid game_uuid'), 400);
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

        if (!$request->filled('duration')) {
            return response()->json(new ErrorResource('Missing duration'), 400);
        }

        $duration = Str::of($request->post('duration'))->match('/([1-9][0-9]*[w|d|h]?)/i');

        if ($duration->isEmpty()) {
            return response()->json(new ErrorResource('Invalid duration format'), 400);
        }

        $actor = User::where('uuid', $actorUuid)->first();
        $target = User::where('uuid', $targetUuid)->first();

        if (is_null($actor)) {
            return response()->json(new ErrorResource('Actor does not exist'), 400);
        }

        if (is_null($target)) {
            return response()->json(new ErrorResource('Target does not exist'), 400);
        }

        $hours = 1;

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

        $log = new KickBanLog();

        $log->game_uuid = $gameUuid;
        $log->is_ban = true;
        $log->banned_until = Carbon::now()->addHours($hours);
        $log->reason = $request->post('reason');

        $log->actingUser()->associate($actor);
        $log->targetUser()->associate($target);

        if ($log->save()) {
            return new SuccessResource(['duration_hours' => $hours]);
        }

        return response()->json(new ErrorResource('An unknown error occurred'), 500);
    }
}
