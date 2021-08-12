<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMute extends Model
{
    use HasFactory;

    protected $casts = [
        'muted_until' => 'datetime',
    ];

    protected $appends = [
        'is_permanent'
    ];

    public function actingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acting_user_id', 'id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id');
    }

    public function getIsPermanentAttribute()
    {
        return is_null($this->muted_until);
    }
}
