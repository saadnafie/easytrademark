<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryClass extends Model
{
   public function classes(){
		return $this->belongsTo('App\Models\Classes','class_id');
    }
}
