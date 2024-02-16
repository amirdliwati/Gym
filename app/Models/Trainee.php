<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;
 	public $table="trainees";

     public function users()
    {
        return $this->hasOne('App\Models\User','trainee_id','id');
    }

    public function countrie()
    {
        return $this->belongsTo('App\Models\Countrie','country_id','id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Addresse','trainee_id','id');
    }

    public function phones()
    {
        return $this->hasMany('App\Models\Phone','trainee_id','id');
    }

    public function emergencies()
    {
        return $this->hasMany('App\Models\Emergencie','trainee_id','id');
    }

    public function employees_trainee()
    {
        return $this->belongsTo('App\Models\Employees_trainee','trainee_id','id');
    }

    public function trainee_attendances()
    {
        return $this->hasMany('App\Models\Trainee_attendance','trainee_id','id');
    }

    public function membership()
    {
        return $this->belongsTo('App\Models\Membership','membership_id','id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position','position_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department','department_id','id');
    }

    public function attendances()
    {
        return $this->hasMany('App\Models\Attendance','trainee_id','id');
    }

    public function offer_trainees()
    {
        return $this->hasMany('App\Models\Offer_trainee','trainee_id','id');
    }

}
