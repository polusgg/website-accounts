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
            /**
             * Lobby perks
             */
            [
                'perk_key' => 'lobby.code.custom',
                'display_name' => 'Custom 4 or 6 letter lobby codes',
            ],
            [
                'perk_key' => 'lobby.size.25',
                'display_name' => 'Ability to host lobbies with up to 25 players',
            ],
            [
                'perk_key' => 'lobby.size.50',
                'display_name' => 'Ability to host lobbies with up to 50 players',
            ],
            [
                'perk_key' => 'lobby.size.100',
                'display_name' => 'Ability to host lobbies with up to 100 players',
            ],

            /**
             * Player perks
             */
            [
                'perk_key' => 'name.color.gold',
                'display_name' => 'Among Us player name is colored gold (can be turned off)',
            ],
            [
                'perk_key' => 'name.color.match',
                'display_name' => 'Among Us player name color matches your player color (can be turned off)',
            ],
            [
                'perk_key' => 'player.color.rgb',
                'display_name' => 'Custom player color using an RGB color picker',
            ],

            /**
             * Server access perks
             */
            [
                'perk_key' => 'server.access.dev',
                'display_name' => 'Access to development servers',
            ],
            [
                'perk_key' => 'server.access.beta',
                'display_name' => 'Access to beta testing servers',
            ],
            [
                'perk_key' => 'server.access.creator',
                'display_name' => 'Access to Creator-only servers',
            ],

            /**
             * Creator manager perks
             */
            [
                'perk_key' => 'creator.manage',
                'display_name' => 'Manage the Creator status of other users',
            ],

            /**
             * Moderation perks
             */
            [
                'perk_key' => 'mod.kick',
                'display_name' => 'Kick players from a game',
            ],
            [
                'perk_key' => 'mod.ban',
                'display_name' => 'Ban players from a game',
            ],

            /**
             * Cosmetic perks
             */
            [
                'perk_key' => 'cosmetic.item.create',
                'display_name' => 'Ability to create cosmetic items',
            ],
            [
                'perk_key' => 'cosmetic.item.update',
                'display_name' => 'Ability to update cosmetic items',
            ],
            [
                'perk_key' => 'cosmetic.bundle.create',
                'display_name' => 'Ability to create cosmetic item bundles',
            ],
            [
                'perk_key' => 'cosmetic.bundle.update',
                'display_name' => 'Ability to update cosmetic item bundles',
            ],

            /**
             * Purchase perks
             */
            [
                'perk_key' => 'purchase.get.all',
                'display_name' => 'Ability to get information about any purchase',
            ],
            [
                'perk_key' => 'purchase.authenticate.all',
                'display_name' => 'Ability to forcibly verify any purchase',
            ],
            [
                'perk_key' => 'purchase.update',
                'display_name' => 'Ability to update purchases',
            ],
        ];

        collect($perks)->map(fn($perk) => GamePerk::create($perk));
    }
}
