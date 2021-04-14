<?php

use App\Discord\Discord;
use App\Models\User;
use App\Models\KickBanLog;
use App\Models\DiscordRole;
use App\Http\Resources\UserResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api-private')->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('{user}', function (User $user) {
            return new UserResource($user);
        })->missing(fn(Request $request) => response()->json(new ErrorResource('User not found'), 404));

        Route::post('{user}/roles', function (Request $request, User $user) {
            $discordRoles = DiscordRole::all();
            $roles = app(Discord::class)->getRoles($user->discord_snowflake);

            $userRoles = $discordRoles->filter(
                fn($role) =>
                    $roles->contains($role->role_snowflake) ||
                    ($user->is_creator && $role->role_snowflake == config('services.discord.creator_role_id'))
            );

            $user->discordRoles()->sync($userRoles);

            if ($user->save()) {
                return new SuccessResource();
            }

            return response()->json(new ErrorResource('An unknown error occurred'), 500);
        })->missing(fn(Request $request) => response()->json(new ErrorResource('User not found'), 404));
    });

    // Route::get('banme', function (Request $request) {
    //     \App\Models\KickBanLog::forceCreate([
    //         'game_uuid' => \Str::uuid(),
    //         'acting_user_id' => 2,
    //         'target_user_id' => 1,
    //         'is_ban' => true,
    //         'banned_until' => \Carbon\Carbon::now()->addMinutes(1),
    //         'reason' => '69420',
    //     ]);
    // });

    Route::prefix('logs')->group(function () {
        Route::put('kick', function (Request $request) {
            if (!$request->filled('game_uuid')) {
                return response()->json(new ErrorResource('Missing game_uuid'), 400);
            }

            $gameUuid = $request->input('game_uuid');

            if (!Str::isUuid($gameUuid)) {
                return response()->json(new ErrorResource('Invalid game_uuid format'), 400);
            }

            if (!$request->filled('actor_uuid')) {
                return response()->json(new ErrorResource('Missing actor_uuid'), 400);
            }

            $actorUuid = $request->input('actor_uuid');

            if (!Str::isUuid($actorUuid)) {
                return response()->json(new ErrorResource('Invalid actor_uuid format'), 400);
            }

            if (!$request->filled('target_uuid')) {
                return response()->json(new ErrorResource('Missing target_uuid'), 400);
            }

            $targetUuid = $request->input('target_uuid');

            if (!Str::isUuid($targetUuid)) {
                return response()->json(new ErrorResource('Invalid target_uuid format'), 400);
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
            $log->reason = $request->input('reason');

            $log->actingUser()->associate($actor);
            $log->targetUser()->associate($target);

            if ($log->save()) {
                return new SuccessResource();
            }

            return response()->json(new ErrorResource('An unknown error occurred'), 500);
        });

        Route::put('ban', function (Request $request) {
            if (!$request->filled('game_uuid')) {
                return response()->json(new ErrorResource('Missing game_uuid'), 400);
            }

            $gameUuid = $request->input('game_uuid');

            if (!Str::isUuid($gameUuid)) {
                return response()->json(new ErrorResource('Invalid game_uuid format'), 400);
            }

            if (!$request->filled('actor_uuid')) {
                return response()->json(new ErrorResource('Missing actor_uuid'), 400);
            }

            $actorUuid = $request->input('actor_uuid');

            if (!Str::isUuid($actorUuid)) {
                return response()->json(new ErrorResource('Invalid actor_uuid format'), 400);
            }

            if (!$request->filled('target_uuid')) {
                return response()->json(new ErrorResource('Missing target_uuid'), 400);
            }

            $targetUuid = $request->input('target_uuid');

            if (!Str::isUuid($targetUuid)) {
                return response()->json(new ErrorResource('Invalid target_uuid format'), 400);
            }

            if (!$request->filled('duration')) {
                return response()->json(new ErrorResource('Missing duration'), 400);
            }

            $duration = Str::of($request->input('duration'))->match('/([1-9][0-9]*[w|d|h]?)/i');

            if ($duration->isEmpty()) {
                return response()->json(new ErrorResource('Invalid duration format'), 400);
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

            if ($duration->endsWith('w')) {
                $duration = (int) (string) $duration->substr(0, -1) * 24 * 7;
            } else if ($duration->endsWith('d')) {
                $duration = (int) (string) $duration->substr(0, -1) * 24;
            } else if ($duration->endsWith('h')) {
                $duration = (int) (string) $duration->substr(0, -1);
            } else {
                $duration = (int) (string) $duration;
            }

            $log = new KickBanLog();

            $log->game_uuid = $gameUuid;
            $log->is_ban = true;
            $log->banned_until = Carbon::now()->addHours($duration);
            $log->reason = $request->input('reason');

            $log->actingUser()->associate($actor);
            $log->targetUser()->associate($target);

            if ($log->save()) {
                return new SuccessResource(['duration_hours' => $duration]);
            }

            return response()->json(new ErrorResource('An unknown error occurred'), 500);
        });
    });
});
