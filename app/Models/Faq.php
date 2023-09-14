<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Faq extends Model
{
	public function getQuestionAttribute($value) {
        return $this->{'question_' . App::getLocale()};
    }
	
	public function getAnswerAttribute($value) {
        return $this->{'answer_' . App::getLocale()};
    }
}
