<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackageCountryFee extends Model
{
	
	protected $fillable = ['isActive', 'fees'];
	
    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }


    public function service_package(){
        return $this->belongsTo('App\Models\ServicePackageFee','service_package_id')->with('service')->with('package');
    }

}
