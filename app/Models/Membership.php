<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
	public $table="memberships";

	public function employees()
    {
        return $this->hasMany('App\Models\Employee','membership_id','id');
    }

}
