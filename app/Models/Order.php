<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'coupon_code',
        'discount_amount',
        'subtotal',
        'shipping_amount',
        'total_amount',
        'shipping_method',
        'province',
        'city',
        'address',
        'zip',
        'notes',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivered_at' => 'datetime',

    ];

    // ── Relationships ──────────────────────
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnOrder()
    {
        return $this->hasOne(ReturnOrder::class);
    }
}
