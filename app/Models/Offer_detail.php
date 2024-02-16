<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_detail extends Model
{
    use HasFactory;
	public $table="offer_details";

	public function offer()
    {
        return $this->belongsTo('App\Models\Offer','offer_id','id');
    }

}
