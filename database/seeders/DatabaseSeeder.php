<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DiscordRoleSeeder::class,
            CosmeticHatSeeder::class,
            CosmeticPetSeeder::class,
            CosmeticSkinSeeder::class,
            GamePerkSeeder::class,
            PrivateTokenSeeder::class,
            RolePerkSeeder::class,
        ]);
    }
}
