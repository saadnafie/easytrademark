<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDiscountHistory extends Model
{
    protected $table = 'users_discounts_history';
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
//
//    public function orderTranslations()
//    {
//        return $this->hasMany(OrderTranslation::class);
//    }
}

