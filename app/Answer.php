<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Class Answer
 * @package App
 * @author Hesham Mohamed <hesham.mohamed19930@gmail.com>
 */
class Answer extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getAnswerAttribute($value) {
        return $this->{'answer_' . App::getLocale()};
    }

    public function getFinalAnswerMessageAttribute($value) {
        return $this->{'final_answer_message_' . App::getLocale()};
    }
}
