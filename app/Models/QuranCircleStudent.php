<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuranCircleStudent extends Model
{
    use HasFactory;

    protected $table = 'quran_circles_students'; // custom table name

    protected $fillable = ['quran_circle', 'teacher_id', 'student_name', 'phone_number', 'is_registered'];

    // Belongs to a circle
    public function circle()
    {
        return $this->belongsTo(QuranCircle::class, 'class_id');
    }

    // Belongs to a teacher (who registered the student)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Optional: link to actual student account after registration
    public function studentAccount()
    {
        return $this->belongsTo(Student::class, 'phone_number', 'phone_number');
    }
}

