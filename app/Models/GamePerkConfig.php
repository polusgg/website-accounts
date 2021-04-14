<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePerkConfig extends Model
{
    use HasFactory;

    protected $casts = [
        'name_color_gold_enabled' => 'boolean',
        'name_color_match_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setLobbyCodeCustomValueAttribute($value)
    {
        $value = strtoupper($value);

        $this->attributes['lobby_code_custom_value'] = empty($value) ? null : $value;
    }
}