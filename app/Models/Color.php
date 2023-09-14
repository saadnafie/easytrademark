<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Color extends Model
{
	public function getColorNameAttribute($value) {
        return $this->{'color_name_' . App::getLocale()};
    }
}
