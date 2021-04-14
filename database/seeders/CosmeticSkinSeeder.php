<?php

namespace Database\Seeders;

use App\Models\CosmeticSkin;
use Illuminate\Database\Seeder;

class CosmeticSkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skins = [];

        collect($skins)->map(fn($skin) => CosmeticSkin::create($skin));
    }
}
