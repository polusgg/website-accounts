<?php

namespace Database\Seeders;

use Str;
use App\Models\PrivateToken;
use Illuminate\Database\Seeder;

class PrivateTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tokens = [
            ['name' => 'bot-discord', 'token' => Str::random(100)],
            ['name' => 'region-na-east', 'token' => Str::random(100)],
            ['name' => 'region-na-west', 'token' => Str::random(100)],
            ['name' => 'region-eu', 'token' => Str::random(100)],
            ['name' => 'region-asia', 'token' => Str::random(100)],
            ['name' => 'region-na-west-streamer', 'token' => Str::random(100)],
            ['name' => 'region-eu-streamer', 'token' => Str::random(100)],
        ];

        collect($tokens)->map(fn($token) => PrivateToken::create($token));
    }
}
