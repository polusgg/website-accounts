<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCosmeticSkinDiscordRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosmetic_skin_discord_role', function (Blueprint $table) {
            $table->foreignId('cosmetic_skin_id')->constrained()->onDelete('cascade');
            $table->foreignId('discord_role_id')->constrained()->onDelete('cascade');
            $table->primary(['cosmetic_skin_id', 'discord_role_id'], 'skin_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cosmetic_skin_discord_role');
    }
}
