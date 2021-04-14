<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordRoleGamePerkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_role_game_perk', function (Blueprint $table) {
            $table->foreignId('discord_role_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_perk_id')->constrained()->onDelete('cascade');
            $table->primary(['discord_role_id', 'game_perk_id'], 'role_perk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discord_role_game_perk');
    }
}
