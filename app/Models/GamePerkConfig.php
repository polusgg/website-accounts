<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePerkConfig extends Model
{
    use HasFactory;

    protected $casts = [
        'name_color_gold_enabled' => 'boolean',
        'name_color_match_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setLobbyCodeCustomValueAttribute($value)
    {
        $value = strtoupper($value);

        $this->attributes['lobby_code_custom_value'] = empty($value) ? null : $value;
    }
}
