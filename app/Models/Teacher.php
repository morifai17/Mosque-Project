<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Teacher extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;

        protected $fillable = ['first_name', 'last_name', 'avatar', 'teacher_name', 'phone_number', 'password'];
    protected $hidden   = ['password'];


     public function students()
    {
        return $this->hasMany(Student::class);
    }

  public function quranCircle()
{
    // One teacher has exactly one circle
    return $this->hasOne(QuranCircle::class);
}
public function preRegisteredStudents()
{
    return $this->hasMany(QuranCircleStudent::class);
}

}