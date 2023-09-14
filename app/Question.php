<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Class Question
 * @package App
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class Question extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function getQuestionAttribute($value) {
        return $this->{'question_' . App::getLocale()};
    }
}
