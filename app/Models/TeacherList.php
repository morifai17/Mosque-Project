<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherList extends Model
{
    use SoftDeletes;

    protected $table = 'teacher_list';

    protected $fillable = [
        'first_name',
        'last_name',
        'code'
    ];


}
