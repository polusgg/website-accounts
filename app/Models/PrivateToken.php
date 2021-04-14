<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateToken extends Model
{
    use HasFactory;

    protected $hidden = [
        'token',
    ];
}
