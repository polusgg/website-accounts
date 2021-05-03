<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CosmeticPet extends Model
{
    use HasFactory;

    public function discordRoles(): BelongsToMany
    {
        return $this->belongsToMany(DiscordRole::class);
    }
}
