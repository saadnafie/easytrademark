<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Classes extends Model
{
    //
	
	public function getClassBriefAttribute($value) {
        return $this->{'class_brief_' . App::getLocale()};
    }
}
