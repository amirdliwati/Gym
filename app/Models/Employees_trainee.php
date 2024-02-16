<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees_trainee extends Model
{
    use HasFactory;
	public $table="employees_trainees";

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }

    public function trainees()
    {
        return $this->hasMany('App\Models\Trainee','trainee_id','id');
    }

}
