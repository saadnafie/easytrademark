<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{

	protected $fillable = [
        'member_representative_id'
    ];

    public function user(){
		return $this->belongsTo('App\Models\User','user_id');
    }
	
	public function representative(){
		return $this->belongsTo('App\Models\User','member_representative_id');
    }

    public function trademark_country(){
		return $this->hasMany('App\Models\TrademarkCountry','trademark_id','id')->with('trademark_country_classes')->with('country');
	}
	
	public function trademark_response_doc(){
		return $this->hasMany('App\Models\TrademarkResponseDocument','trademark_id','id');
	}

}
