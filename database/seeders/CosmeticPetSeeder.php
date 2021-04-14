<?php

namespace Database\Seeders;

use App\Models\CosmeticPet;
use Illuminate\Database\Seeder;

class CosmeticPetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pets = [];

        collect($pets)->map(fn($pet) => CosmeticPet::create($pet));
    }
}
