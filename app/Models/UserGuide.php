<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class UserGuide extends Model
{
	public function getTitleAttribute($value) {
        return $this->{'title_' . App::getLocale()};
    }
	public function getDescriptionAttribute($value) {
        return $this->{'description_' . App::getLocale()};
    }

	public function images()
    {
        return $this->hasMany('App\Models\UserGuideImage', 'user_guide_id');
    }
}

