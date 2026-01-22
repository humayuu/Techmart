<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductDetailController extends Controller
{
    /**
     * Function for filter product
     */
    public function ProductFilter()
    {
        $newArrival = Product::with(['category', 'brand'])
            ->latest()
            ->limit(10)
            ->get();

        $specialOffer = Product::with(['category', 'brand'])
            ->where('special_offer', true)
            ->limit(10)
            ->get();

        $featured = Product::with(['category', 'brand'])
            ->where('featured', true)
            ->limit(10)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched product data',
            'data' => [
                'newArrival' => $newArrival,
                'specialOffer' => $specialOffer,
                'featured' => $featured,
            ],
        ], 200);
    }
}
