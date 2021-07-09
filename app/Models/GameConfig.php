<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    protected $attributes = [
        'config' => '[]'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
