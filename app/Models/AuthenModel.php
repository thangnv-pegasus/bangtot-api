<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUser',
        'accessToken',
        'refreshToken',
        'tokenExpired',
        'refreshToken_expired'
    ];
}