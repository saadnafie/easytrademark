<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkResponse extends Model
{

    public function service(){
        return $this->belongsTo('App\Models\Service','service_id');
    }

}
