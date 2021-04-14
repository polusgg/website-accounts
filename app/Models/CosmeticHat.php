<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CosmeticHat extends Model
{
    use HasFactory;

    public function discordRoles()
    {
        return $this->belongsToMany(DiscordRole::class);
    }
}
