<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimConventionDetail extends Model
{
	public function country(){
        return $this->belongsTo('App\Models\ApplicantCountry','country_id');
    }
}
