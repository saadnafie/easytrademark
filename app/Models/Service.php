<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Service extends Model
{
    protected $fillable = ['isActive','service_name'];

    public function how_details(){
      return $this->hasMany('App\Models\ServiceHowDetail', 'service_id', 'id');
    }

    public function service_country_doc(){
        return $this->hasMany('App\Models\ServiceCountryDocument','service_id')->with('document');
    }

    public function package(){
        return $this->belongsToMany('App\Models\Package','service_package_fees','service_id','package_id');
    }
	
	
	public function getServiceNameAttribute($value) {
        return $this->{'service_name_' . App::getLocale()};
    }
	public function getServiceDescriptionAttribute($value) {
        return $this->{'service_description_' . App::getLocale()};
    }
	
}
