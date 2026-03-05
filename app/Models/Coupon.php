<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'coupon_name',
        'coupon_discount',
        'valid_until',
        'status',
    ];
}
