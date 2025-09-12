<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;

        protected $fillable = ['first_name', 'last_name', 'avatar', 'admin_name', 'phone_number', 'password'];
    protected $hidden   = ['password'];
}
