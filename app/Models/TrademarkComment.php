<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrademarkComment extends Model
{
    use SoftDeletes;
	    public function user(){
		return $this->belongsTo('App\Models\User','user_id');
    }

		public function trademark(){
		return $this->belongsTo('App\Models\Trademark','trademark_id');
	}
}
