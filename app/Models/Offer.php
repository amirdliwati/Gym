<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
	public $table="offers";

	public function offer_detail()
    {
        return $this->hasOne('App\Models\Offer_detail','offer_id','id');
    }

    public function currencie()
    {
        return $this->belongsTo('App\Models\Currencie','currency_id','id');
    }

}
