<?php

namespace Database\Seeders;

use App\Models\GamePerk;
use Illuminate\Database\Seeder;

class GamePerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perks = [
            [
                'perk_key' => 'lobby.code.custom',
                'display_name' => 'Custom 4 or 6 letter lobby codes',
            ],
            [
                'perk_key' => 'lobby.size.large',
                'display_name' => 'Exclusive ability to host lobbies with up to 25 players',
            ],
            [
                'perk_key' => 'name.color.gold',
                'display_name' => 'Gold player name in all lobbies (can be turned off)',
            ],
            [
                'perk_key' => 'name.color.match',
                'display_name' => 'Player name matches player color in all lobbies (can be turned off)',
            ],

            /**
             * Gamemodes
             */
            [
                'perk_key' => 'gamemode.all',
                'display_name' => 'Access to all gamemodes',
            ],
            [
                'perk_key' => 'gamemode.slenderman',
                'display_name' => 'Access to the Slenderman gamemode',
            ],
            [
                'perk_key' => 'gamemode.hot_potato',
                'display_name' => 'Access to the Hot Potato gamemode',
            ],
            [
                'perk_key' => 'gamemode.town_of_polus',
                'display_name' => 'Access to the Town Of Polus gamemode',
            ],
            [
                'perk_key' => 'gamemode.zombies',
                'display_name' => 'Access to the Zombies gamemode',
            ],
            [
                'perk_key' => 'gamemode.venteleporter',
                'display_name' => 'Access to the Venteleporter gamemode',
            ],
            [
                // Creator only
                'perk_key' => 'gamemode.c4',
                'display_name' => 'Access to the C4 gamemode',
            ],

            /**
             * Creator Abilities
             */
            [
                'perk_key' => 'server.access.creator',
                'display_name' => 'Access to Creator-only servers',
            ],

            /**
             * Creator Manager Abilities
             */
            [
                'perk_key' => 'creator.manage',
                'display_name' => 'Manage the Creator status of other users',
            ],

            /**
             * Moderation Abilities
             */
            [
                'perk_key' => 'mod.kick',
                'display_name' => 'Kick players from a game',
            ],
            [
                'perk_key' => 'mod.ban',
                'display_name' => 'Ban players from a game',
            ],
        ];

        collect($perks)->map(fn($perk) => GamePerk::create($perk));
    }
}
