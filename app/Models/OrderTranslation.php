<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTranslation extends Model
{
	public function order(){
		return $this->belongsTo('App\Models\Order','order_id');
    }

	public function translation_document(){
		return $this->hasMany('App\Models\TranslationDocument','order_translation_id','id');
	}

	public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
