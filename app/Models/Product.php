<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // In App\Models\Product.php
    protected $fillable = [
        'brand_id',
        'category_id',
        'product_name',
        'product_slug',
        'product_code',
        'product_qty',
        'product_tags',
        'short_description',
        'long_description',
        'selling_price',
        'discount_price',
        'product_thumbnail',
        'product_multiple_image',
        'featured',
        'special_offer',
        'product_weight',
        'other_info',
        'status'
    ];

    protected  $casts = [
        'product_multiple_image' => 'array',
    ];
}
