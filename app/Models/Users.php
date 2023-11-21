<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = ['firstName', 'lastName', 'mobile', 'email', 'otp' , 'password'];
    protected $attributes = [
        'otp' => '0',
    ];
}
