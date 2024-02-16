<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_trainee extends Model
{
    use HasFactory;
	public $table="offer_trainees";

	public function trainee()
    {
        return $this->belongsTo('App\Models\Trainee','trainee_id','id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer','offer_id','id');
    }
}
