<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Class Survey
 * @package App
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class Survey extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getSurveyNameAttribute($value) {
        return $this->{'survey_name_' . App::getLocale()};
    }

    public function getTitleAttribute($value) {
        return $this->{'title_' . App::getLocale()};
    }

    public function getMessageAttribute($value) {
        return $this->{'message_' . App::getLocale()};
    }

    public function getDescriptionAttribute($value) {
        return $this->{'description_' . App::getLocale()};
    }
}
