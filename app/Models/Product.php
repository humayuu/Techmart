<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'product_name' => $this->product_name,
            'product_slug' => $this->product_slug,
            'selling_price' => $this->selling_price,
            'short_description' => $this->short_description,
        ];
    }

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
            return asset('images/products/thumbnail/'.$this->product_thumbnail);
        }

        return asset('frontend/assets/images/product-image/1.webp');
    }

    public function getPriceAttribute()
    {
        $selling = (float) ($this->selling_price ?? 0);
        $discount = (float) ($this->discount_price ?? 0);

        return max(0.0, $selling - $discount);
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
            $images[] = asset('images/products/thumbnail/'.$this->product_thumbnail);
        }

        // Add additional images
        if ($this->product_multiple_image && is_array($this->product_multiple_image)) {
            foreach ($this->product_multiple_image as $image) {
                $images[] = asset('images/products/additional_images/'.$image);
            }
        }

        return $images;
    }
}
