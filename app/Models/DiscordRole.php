<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiscordRole extends Model
{
    use HasFactory;

    protected $with = ['gamePerks'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function cosmeticHats(): BelongsToMany
    {
        return $this->belongsToMany(CosmeticHat::class);
    }

    public function cosmeticPets(): BelongsToMany
    {
        return $this->belongsToMany(CosmeticPet::class);
    }

    public function cosmeticSkins(): BelongsToMany
    {
        return $this->belongsToMany(CosmeticSkin::class);
    }

    public function gamePerks(): BelongsToMany
    {
        return $this->belongsToMany(GamePerk::class);
    }

    public function getRgbColorAttribute(): string
    {
        $color = $this->attributes['color'];

        return sprintf(
            'rgba(%d, %d, %d, 1)',
            ($color >> 16) & 0xff,
            ($color >> 8) & 0xff,
            $color & 0xff,
        );
    }
}
