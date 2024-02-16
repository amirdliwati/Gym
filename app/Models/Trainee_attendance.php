<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee_attendance extends Model
{
    use HasFactory;
	public $table="trainee_attendances";

    public function trainees()
    {
        return $this->hasMany('App\Models\Trainee','trainee_id','id');
    }

}
