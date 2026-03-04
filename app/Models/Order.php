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
        'subtotal',
        'shipping_amount',
        'total_amount',
        'shipping_method',
        'province',
        'city',
        'address',
        'zip',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
