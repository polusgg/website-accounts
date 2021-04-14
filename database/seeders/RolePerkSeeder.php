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
        $lobbySizeLarge = GamePerk::where('perk_key', 'lobby.size.large')->firstOrFail()->id;
        $nameColorGold = GamePerk::where('perk_key', 'name.color.gold')->firstOrFail()->id;
        $nameColorMatch = GamePerk::where('perk_key', 'name.color.match')->firstOrFail()->id;
        $gamemodeAll = GamePerk::where('perk_key', 'gamemode.all')->firstOrFail()->id;
        $gamemodeSlenderman = GamePerk::where('perk_key', 'gamemode.slenderman')->firstOrFail()->id;
        $gamemodeHotPotato = GamePerk::where('perk_key', 'gamemode.hot_potato')->firstOrFail()->id;
        $gamemodeTownOfPolus = GamePerk::where('perk_key', 'gamemode.town_of_polus')->firstOrFail()->id;
        $gamemodeZombies = GamePerk::where('perk_key', 'gamemode.zombies')->firstOrFail()->id;
        $gamemodeVenteleporter = GamePerk::where('perk_key', 'gamemode.venteleporter')->firstOrFail()->id;
        $gamemodeC4 = GamePerk::where('perk_key', 'gamemode.c4')->firstOrFail()->id;
        $serverAccessCreator = GamePerk::where('perk_key', 'server.access.creator')->firstOrFail()->id;
        $creatorManage = GamePerk::where('perk_key', 'creator.manage')->firstOrFail()->id;
        $modKick = GamePerk::where('perk_key', 'mod.kick')->firstOrFail()->id;
        $modBan = GamePerk::where('perk_key', 'mod.ban')->firstOrFail()->id;

        // Elite
        DiscordRole::where('role_snowflake', '820165177554763807')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $nameColorGold,
        ]);
        // Legend
        DiscordRole::where('role_snowflake', '820165176769773590')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $nameColorGold,
            $nameColorMatch,
        ]);
        // Impostor
        DiscordRole::where('role_snowflake', '820165176150065162')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $nameColorGold,
            $nameColorMatch,
            $lobbyCodeCustom,
            $lobbySizeLarge,
        ]);
        // Creator
        DiscordRole::where('role_snowflake', '820165174879059988')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $serverAccessCreator,
        ]);
        // Creator Manager
        DiscordRole::where('role_snowflake', '823088311970168863')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $serverAccessCreator,
            $creatorManage,
        ]);
        // Artist
        DiscordRole::where('role_snowflake', '822653061490409494')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $nameColorGold,
            $nameColorMatch,
        ]);
        // Game Mod
        DiscordRole::where('role_snowflake', '830955578833895454')->firstOrFail()->gamePerks()->sync([
            $gamemodeSlenderman,
            $gamemodeHotPotato,
            $gamemodeTownOfPolus,
            $gamemodeZombies,
            $gamemodeVenteleporter,
            $gamemodeC4,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $nameColorGold,
            $nameColorMatch,
        ]);
        // Developer
        DiscordRole::where('role_snowflake', '820165170440962088')->firstOrFail()->gamePerks()->sync([
            $gamemodeAll,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $nameColorGold,
            $nameColorMatch,
        ]);
        // Management
        DiscordRole::where('role_snowflake', '821582796782436352')->firstOrFail()->gamePerks()->sync([
            $gamemodeAll,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $nameColorGold,
            $nameColorMatch,
            $serverAccessCreator,
            $creatorManage,
            $modKick,
            $modBan,
        ]);
        // Owner
        DiscordRole::where('role_snowflake', '821614871073390602')->firstOrFail()->gamePerks()->sync([
            $gamemodeAll,
            $lobbyCodeCustom,
            $lobbySizeLarge,
            $nameColorGold,
            $nameColorMatch,
            $serverAccessCreator,
            $creatorManage,
            $modKick,
            $modBan,
        ]);
    }
}
