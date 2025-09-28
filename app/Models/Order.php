<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'total_price',
        'coupon_id',
        'final_price',
    ];
    
     public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('price', 'quantity');
    }

    public function products_pivot()
    {
        return $this->hasMany(OrderProduct::class);
    }

 public function statuses()
    {
        return $this->hasMany(OrderStatus::class)->orderBy('created_at');
    }

    // Latest status for student
    public function latestStatus()
    {
        return $this->hasOne(OrderStatus::class)->latestOfMany();
    }

      public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
