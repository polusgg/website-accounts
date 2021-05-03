<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KickBanLog extends Model
{
    use HasFactory;

    protected $casts = [
        'is_ban' => 'boolean',
        'banned_until' => 'datetime',
    ];

    public function actingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acting_user_id', 'id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id');
    }
}
