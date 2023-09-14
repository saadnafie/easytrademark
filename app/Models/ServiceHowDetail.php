<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ServiceHowDetail extends Model
{
   
	public function getServiceWhatAttribute($value) {
        return $this->{'service_what_' . App::getLocale()};
    }
	public function getServiceWhyAttribute($value) {
        return $this->{'service_why_' . App::getLocale()};
    }
	public function getServiceWhenAttribute($value) {
        return $this->{'service_when_' . App::getLocale()};
    }
	public function getServiceHowAttribute($value) {
        return $this->{'service_how_' . App::getLocale()};
    }
	
}
