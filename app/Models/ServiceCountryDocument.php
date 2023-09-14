<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCountryDocument extends Model
{
        public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }

     public function service(){
        return $this->belongsTo('App\Models\Service','service_id');
    }
    public function document(){
        return $this->belongsTo('App\Models\DocumentTemplate','document_id');
    }

}
