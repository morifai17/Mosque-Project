<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPoint extends Model
{
    use HasFactory;
    public $timestamps = false; // لأننا نستخدم changed_at فقط

    protected $fillable = [
        'student_id', 'points_change', 'reason', 'performed_by', 'changed_at'
    ];

    // علاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
