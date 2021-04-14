<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCosmeticHatDiscordRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosmetic_hat_discord_role', function (Blueprint $table) {
            $table->foreignId('cosmetic_hat_id')->constrained()->onDelete('cascade');
            $table->foreignId('discord_role_id')->constrained()->onDelete('cascade');
            $table->primary(['cosmetic_hat_id', 'discord_role_id'], 'skin_hat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cosmetic_hat_discord_role');
    }
}
