<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    
    public function service_country_doctemplate(){
		return $this->hasMany('App\Models\ServiceCountryDocument','document_id','id')->with('service')->with('country');
	}
	
}
