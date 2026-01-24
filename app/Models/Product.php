<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Relationship with brand table
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
        'status',
    ];

    protected $casts = [
        'product_multiple_image' => 'array',
    ];

    // Update this line - add 'category_display'
    protected $appends = ['image_url', 'price', 'category_display'];

    public function getImageUrlAttribute()
    {
        if ($this->product_thumbnail) {
            return asset('images/products/'.$this->product_thumbnail);
        }

        return asset('frontend/assets/images/product-image/1.webp');
    }

    public function getPriceAttribute()
    {
        return $this->discount_price ?? $this->selling_price;
    }

    // Add this new accessor
    public function getCategoryDisplayAttribute()
    {
        return $this->category ? $this->category->category_name : 'Uncategorized';
    }

    public function getAllImagesAttribute()
    {
        $images = [];

        // Add thumbnail
        if ($this->product_thumbnail) {
            $images[] = asset('images/products/'.$this->product_thumbnail);
        }

        // Add additional images
        if ($this->product_multiple_image && is_array($this->product_multiple_image)) {
            foreach ($this->product_multiple_image as $image) {
                $images[] = asset('images/products/'.$image);
            }
        }

        return $images;
    }
}
