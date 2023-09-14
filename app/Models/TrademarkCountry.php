<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkCountry extends Model
{
	
	protected $fillable = [
        'member_representative_id'
    ];
	
    public function trademark_country_classes()
    {
        return $this->hasMany('App\Models\TrademarkCountryClasses', 'trademark_country_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function trademark()
    {
        return $this->belongsTo('App\Models\Trademark', 'trademark_id')->with('user')->with('representative');
    }

    public function trademark_filling()
    {
        return $this->hasOne('App\Models\TrademarkFilling');
    }

    public function trademark_document()
    {
        return $this->hasMany('App\Models\TrademarkDocument')->with('document_title');
    }
	
	public function orders(){
		return $this->belongsToMany('App\Models\Order', 'trademark_country_orders','trademark_country_id' , 'order_id')->with('trademark_registration')->with('tm_color');
	}
}
