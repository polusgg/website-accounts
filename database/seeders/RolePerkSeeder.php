<?php

namespace Database\Seeders;

use App\Models\GamePerk;
use App\Models\DiscordRole;
use Illuminate\Database\Seeder;

class RolePerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Perks
        $lobbyCodeCustom = GamePerk::where('perk_key', 'lobby.code.custom')->firstOrFail()->id;
        $lobbySizeTwentyFive = GamePerk::where('perk_key', 'lobby.size.25')->firstOrFail()->id;
        $lobbySizeFifty = GamePerk::where('perk_key', 'lobby.size.50')->firstOrFail()->id;
        $lobbySizeOneHundred = GamePerk::where('perk_key', 'lobby.size.100')->firstOrFail()->id;

        $nameColorGold = GamePerk::where('perk_key', 'name.color.gold')->firstOrFail()->id;
        $nameColorMatch = GamePerk::where('perk_key', 'name.color.match')->firstOrFail()->id;
        $playerColorRgb = GamePerk::where('perk_key', 'player.color.rgb')->firstOrFail()->id;

        $serverAccessDev = GamePerk::where('perk_key', 'server.access.dev')->firstOrFail()->id;
        $serverAccessBeta = GamePerk::where('perk_key', 'server.access.beta')->firstOrFail()->id;
        $serverAccessCreator = GamePerk::where('perk_key', 'server.access.creator')->firstOrFail()->id;

        $creatorManage = GamePerk::where('perk_key', 'creator.manage')->firstOrFail()->id;

        $modKick = GamePerk::where('perk_key', 'mod.kick')->firstOrFail()->id;
        $modBan = GamePerk::where('perk_key', 'mod.ban')->firstOrFail()->id;

        // Beta Tester
        DiscordRole::where('role_snowflake', '832388858405847081')->firstOrFail()->gamePerks()->sync([
            $serverAccessBeta,
        ]);

        // Supporter
        DiscordRole::where('role_snowflake', '822264590254735361')->firstOrFail()->gamePerks()->sync([
            $serverAccessBeta,
        ]);

        // VIP Donator
        DiscordRole::where('role_snowflake', '820165178263994378')->firstOrFail()->gamePerks()->sync([
            $serverAccessBeta,
        ]);

        // Elite
        DiscordRole::where('role_snowflake', '820165177554763807')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $serverAccessBeta,
        ]);

        // Legend
        DiscordRole::where('role_snowflake', '820165176769773590')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $lobbySizeTwentyFive,
            $serverAccessBeta,
        ]);

        // Impostor
        DiscordRole::where('role_snowflake', '820165176150065162')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $serverAccessBeta,
        ]);

        // Jester
        DiscordRole::where('role_snowflake', '820165176150065162')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $lobbySizeOneHundred,
            $serverAccessBeta,
        ]);

        // Creator
        DiscordRole::where('role_snowflake', '820165174879059988')->firstOrFail()->gamePerks()->sync([
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $serverAccessCreator,
        ]);

        // Creator Manager
        DiscordRole::where('role_snowflake', '823088311970168863')->firstOrFail()->gamePerks()->sync([
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $serverAccessCreator,
            $creatorManage,
        ]);

        // Artist
        DiscordRole::where('role_snowflake', '822653061490409494')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $serverAccessBeta,
        ]);

        // Game Mod
        DiscordRole::where('role_snowflake', '830955578833895454')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $serverAccessBeta,
            $modKick,
            $modBan,
        ]);

        // Developer
        DiscordRole::where('role_snowflake', '820165170440962088')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $lobbySizeOneHundred,
            $serverAccessDev,
            $serverAccessBeta,
        ]);

        // Management
        DiscordRole::where('role_snowflake', '821582796782436352')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $lobbySizeOneHundred,
            $serverAccessDev,
            $serverAccessBeta,
            $serverAccessCreator,
            $creatorManage,
            $modKick,
            $modBan,
        ]);

        // Owner
        DiscordRole::where('role_snowflake', '821614871073390602')->firstOrFail()->gamePerks()->sync([
            $nameColorGold,
            $nameColorMatch,
            $playerColorRgb,
            $lobbyCodeCustom,
            $lobbySizeTwentyFive,
            $lobbySizeFifty,
            $lobbySizeOneHundred,
            $serverAccessDev,
            $serverAccessBeta,
            $serverAccessCreator,
            $creatorManage,
            $modKick,
            $modBan,
        ]);
    }
}
