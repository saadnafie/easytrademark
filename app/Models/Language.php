<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Language extends Model
{
    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }
	
	public function getLanguageAttribute($value) {
        return $this->{'language_' . App::getLocale()};
    }
}
