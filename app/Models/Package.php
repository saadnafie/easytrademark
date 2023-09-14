<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Package extends Model
{
	public function service_package(){
       return $this->hasOne('App\Models\ServicePackageFee','package_id','id')->with('service'); 
	}
	
	
	public function getPackageAttribute($value) {
        return $this->{'package_' . App::getLocale()};
    }
	public function getPackageTypeAttribute($value) {
        return $this->{'package_type_' . App::getLocale()};
    }
	public function getPackageDetailsAttribute($value) {
        return $this->{'package_details_' . App::getLocale()};
    }
	
}
