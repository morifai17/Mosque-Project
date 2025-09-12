<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Student extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;

        protected $fillable = ['first_name', 'last_name', 'avatar', 'student_name', 'phone_number', 'password', 'age', 'points'];
    protected $hidden   = ['password'];


      public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

      // A student can have many cart items
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Optional: get all products in the cart directly
    public function productsInCart()
    {
        return $this->belongsToMany(Product::class, 'carts')
                    ->withPivot('quantity', 'total_price')
                    ->withTimestamps();
    }

      public function orders()
    {
        return $this->hasMany(Order::class);
    }

}