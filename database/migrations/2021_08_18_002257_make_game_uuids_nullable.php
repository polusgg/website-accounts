<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeGameUuidsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kick_ban_logs', function (Blueprint $table) {
            $table->uuid('game_uuid')->nullable()->change();
        });

        Schema::table('game_mutes', function (Blueprint $table) {
            $table->uuid('game_uuid')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kick_ban_logs', function (Blueprint $table) {
            $table->uuid('game_uuid')->change();
        });

        Schema::table('game_mutes', function (Blueprint $table) {
            $table->uuid('game_uuid')->change();
        });
    }
}
