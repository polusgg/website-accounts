<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KickBanLog extends Model
{
    use HasFactory;

    protected $casts = [
        'is_ban' => 'boolean',
        'banned_until' => 'datetime',
    ];

    public function actingUser()
    {
        return $this->belongsTo(User::class, 'acting_user_id', 'id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id');
    }
}
