<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ApplicantOccupation extends Model
{
    //
	
	public function getOccupationAttribute($value) {
        return $this->{'occupation_' . App::getLocale()};
    }
}
