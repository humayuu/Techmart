<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'quantity',
        'unit_price',
        'sub_total',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
