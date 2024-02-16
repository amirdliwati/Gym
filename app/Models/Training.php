<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    public $table="trainings";

	public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }
    public function countrie()
    {
        return $this->belongsTo('App\Models\Countrie','course_loc','id');
    }
}
