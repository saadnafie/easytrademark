<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkCountryOrder extends Model
{
		protected $fillable = [
        'country_order_status','response_id','date_expiration','date_action'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id')->with('service_package');
    }

    public function trademark_country()
    {
        return $this->belongsTo('App\Models\TrademarkCountry', 'trademark_country_id')->with('country')->with('trademark_country_classes')->with('trademark')->with('trademark_filling')->with('trademark_document');
    }

    public function trademark_response()
    {
        return $this->belongsTo('App\Models\TrademarkResponse', 'response_id');
    }

	public function trademark_filling(){
		return $this->hasMany('App\Models\TrademarkFilling');
	}

	public function trademark_ctry_order_date(){
		return $this->hasMany('App\Models\TrademarkCountryOrderDate')->with('service_date');
	}
    public function trademark_registration(){
        return $this->hasOne('App\Models\TrademarkRegistration')->with('claim_convention_filling')->with('language')->with('color')
            ->with('applicant_type')->with('applicant_occupation')->with('nationality')->with('applicant_company_type');
    }
	
}
