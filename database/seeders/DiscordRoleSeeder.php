<?php

namespace Database\Seeders;

use App\Models\DiscordRole;
use Illuminate\Database\Seeder;

class DiscordRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            // Community Roles
            ['role_snowflake' => '823009051168079873', 'display_name' => 'Bug Detector', 'color' => 10070453],
            ['role_snowflake' => '823012102183714856', 'display_name' => 'Creative Genius', 'color' => 10070453],
            // Patreon Roles
            ['role_snowflake' => '822264590254735361', 'display_name' => 'Supporter', 'color' => 16557477],
            ['role_snowflake' => '820165178263994378', 'display_name' => 'VIP Donator', 'color' => 16281969],
            ['role_snowflake' => '820165177554763807', 'display_name' => 'Elite', 'color' => 15680580],
            ['role_snowflake' => '820165176769773590', 'display_name' => 'Legend', 'color' => 14427686],
            ['role_snowflake' => '820165176150065162', 'display_name' => 'Impostor', 'color' => 12131356],
            // Creator Role
            ['role_snowflake' => '820165174879059988', 'display_name' => 'Creator', 'color' => 10070453],
            ['role_snowflake' => '823088311970168863', 'display_name' => 'Creator Manager', 'color' => 10070453],
            // Staff Roles
            ['role_snowflake' => '830955578833895454', 'display_name' => 'Game Mod', 'color' => 6333946],
            ['role_snowflake' => '822653061490409494', 'display_name' => 'Artist', 'color' => 16569165],
            ['role_snowflake' => '820165170440962088', 'display_name' => 'Developer', 'color' => 16569165],
            ['role_snowflake' => '821582796782436352', 'display_name' => 'Management', 'color' => 8409767],
            ['role_snowflake' => '821614871073390602', 'display_name' => 'Owner', 'color' => 8409767],
        ];

        collect($roles)->map(fn($role) => DiscordRole::create($role));
    }
}
