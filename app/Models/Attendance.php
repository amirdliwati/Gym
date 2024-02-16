<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
 	public $table="attendances";

 	public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }

    public function trainee()
    {
        return $this->belongsTo('App\Models\Trainee','trainee_id','id');
    }

}
