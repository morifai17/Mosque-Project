<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuranCircleStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
