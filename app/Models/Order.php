<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	protected $fillable = [
        'order_status','response'
    ];

	public function trademark(){
		return $this->belongsTo('App\Models\Trademark','trademark_id')->with('user');
	}

	public function service_package_country(){
		return $this->belongsTo('App\Models\ServicePackageCountryFee','service_package_country_id')->with('country')->with('service_package');
	}

	public function trademark_country_classes(){
		return $this->hasMany('App\Models\TrademarkCountryClasses','order_id','id');
	}

	public function trademark_assignment(){
		return $this->hasOne('App\Models\TrademarkAssignment');
	}

	public function trademark_document(){
		return $this->hasOne('App\Models\TrademarkDocument');
	}

	public function trademark_filling(){
		return $this->hasOne('App\Models\TrademarkFilling');
	}

	public function trademark_registration(){
		return $this->hasOne('App\Models\TrademarkRegistration')->with('claim_convention_filling')->with('language')->with('color')
		->with('applicant_type')->with('applicant_occupation')->with('nationality')->with('applicant_company_type');
	}

	public function tm_address_change(){
		return $this->hasOne('App\Models\TrademarkAddressChange');
	}

	public function tm_name_change(){
		return $this->hasOne('App\Models\TrademarkNameChange');
	}

	public function service_package(){
		return $this->belongsTo('App\Models\ServicePackageFee','service_package_id')->with('service')->with('package');
	}

    public function trademark_country_order(){
        return $this->hasMany('App\Models\TrademarkCountryOrder','order_id','id')->with('trademark_country');
    }

	public function trademark_color(){
		return $this->hasMany('App\Models\TrademarkColor')->with('color');
	}

	public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function user_discount_history()
    {
        return $this->hasOne(UserDiscountHistory::class);
    }
	
	public function tm_color(){
		return $this->belongsToMany('App\Models\Color' , 'trademark_colors', 'order_id' , 'color_id');
	}
}
