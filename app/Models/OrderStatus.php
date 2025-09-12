<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['order_id', 'student_id', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

        public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
