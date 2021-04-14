<?php

namespace Database\Seeders;

use App\Models\CosmeticHat;
use Illuminate\Database\Seeder;

class CosmeticHatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hats = [];

        collect($hats)->map(fn($hat) => CosmeticHat::create($hat));
    }
}
