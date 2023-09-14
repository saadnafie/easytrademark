<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrademarkDocument extends Model
{
    public function document_title()
    {
        return $this->belongsTo('App\Models\RequiredDocument', 'document_id');
    }
}
