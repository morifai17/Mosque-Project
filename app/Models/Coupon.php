<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
    'code',
    'discount_percentage',
    'usage_limit',
    'used_count',
    'expires_at',
    'is_active',
];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

      public function isValid()
    {
        return $this->is_active
            && ($this->expires_at === null || $this->expires_at > now())
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }


      public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
