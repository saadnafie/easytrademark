<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ApplicantType extends Model
{
  
  	public function getTypeAttribute($value) {
        return $this->{'type_' . App::getLocale()};
    }
}
