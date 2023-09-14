<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\App;
use App;

class Community extends Model
{

	
	public function getCountryAttribute($value) {
        return $this->{'country_' . App::getLocale()};
    }
	public function getTitleAttribute($value) {
        return $this->{'title_' . App::getLocale()};
    }
	public function getDescriptionAttribute($value) {
        return $this->{'description_' . App::getLocale()};
    }
	
}
