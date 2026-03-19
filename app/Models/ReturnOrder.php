<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'return_number',
        'status',
        'reason',
        'description',
        'refund_amount',
        'refunded_at',
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function ($return) {
            $year = date('Y');

            $last = ReturnOrder::withTrashed()
                ->whereYear('created_at', $year)
                ->orderByDesc('id')
                ->first();

            if ($last && $last->return_number) {
                $lastNumber = (int) substr($last->return_number, -4);
                $next = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $next = '0001';
            }

            $return->return_number = 'RET-'.$year.$next;
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
