<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Country extends Model
{
	protected $fillable = ['isActive'];
	
	public function service_package_country(){
		return $this->hasMany('App\Models\ServicePackageCountryFee','country_id')->with('service_package');
	}
	
    public function getCountryNameAttribute($value) {
        return $this->{'country_name_' . App::getLocale()};
    }
}
