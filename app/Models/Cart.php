<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'product_id', 'quantity', 'total_price'];

    // Cart belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Cart belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

      public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Get the updated_at attribute in a specific format.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}

