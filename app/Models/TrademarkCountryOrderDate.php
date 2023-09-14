<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkCountryOrderDate extends Model
{
	protected $fillable = [
        'date'
    ];
	
     public function service_date()
    {
        return $this->belongsTo('App\Models\ServiceDate', 'date_sevice_id');
    }
}
