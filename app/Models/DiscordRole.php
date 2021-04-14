<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordRole extends Model
{
    use HasFactory;

    protected $with = ['gamePerks'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function cosmeticHats()
    {
        return $this->belongsToMany(CosmeticHat::class);
    }

    public function cosmeticPets()
    {
        return $this->belongsToMany(CosmeticPet::class);
    }

    public function cosmeticSkins()
    {
        return $this->belongsToMany(CosmeticSkin::class);
    }

    public function gamePerks()
    {
        return $this->belongsToMany(GamePerk::class);
    }

    public function getRgbColorAttribute()
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
