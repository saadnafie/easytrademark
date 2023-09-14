<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class News extends Model
{
    public function images()
    {
        return $this->hasMany('App\Models\NewsImage', 'news_id');
		
    }
	public function getTitleAttribute($value) {
        return $this->{'title_' . App::getLocale()};
    }
	
	public function getDescriptionAttribute($value) {
        return $this->{'description_' . App::getLocale()};
    }
}
