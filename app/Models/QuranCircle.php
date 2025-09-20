<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuranCircleStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;


class QuranCircle extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id','title'];

    // Each circle belongs to a teacher

    public function teacher()
    {
        return $this->belongsTo(TeacherList::class, 'teacher_id');
    }
  
    // The students pre-registered in this circle
    public function preRegisteredStudents()
    {
        return $this->hasMany(QuranCircleStudent::class, 'class_id');
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

    // Optional: get all products in the cart directly
    public function productsInCart()
    {
        return $this->belongsToMany(Product::class, 'carts')
                    ->withPivot('quantity', 'total_price')
                    ->withTimestamps();
    }
}
