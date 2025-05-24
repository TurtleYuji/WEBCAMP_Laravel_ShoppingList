<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'login_id', 
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'login_id'; 
    }
}