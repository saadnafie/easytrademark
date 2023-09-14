<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackageFee extends Model
{
   public function package(){
       return $this->belongsTo('App\Models\Package','package_id');
   }

   public function country_package_fees(){
        return $this->hasOne('App\Models\ServicePackageCountryFee','service_package_id','id')->with('country');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service','service_id');
    }
}
