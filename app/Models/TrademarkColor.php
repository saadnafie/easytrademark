<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkColor extends Model
{
	public function color(){
		return $this->belongsTo('App\Models\Color' , 'color_id');
	}
	
}