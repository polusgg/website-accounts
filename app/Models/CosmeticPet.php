<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CosmeticPet extends Model
{
    use HasFactory;

    public function discordRoles()
    {
        return $this->belongsToMany(DiscordRole::class);
    }
}
