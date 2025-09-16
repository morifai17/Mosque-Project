<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class TeacherList extends Model
{
    use SoftDeletes;

    protected $table = 'teacher_list';

   protected $fillable = [
        'first_name', 
        'last_name',
        'phone_number',
        'code'
    ];

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
