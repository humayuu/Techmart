<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;

class ProductDetailController extends Controller
{
    /**
     * Function for filter product
     */
    public function ProductFilter()
    {
        try {
            $baseQuery = Product::with(['category', 'brand'])
                ->where('status', 'active');

            $newArrival = (clone $baseQuery)
                ->latest()
                ->limit(10)
                ->get();

            $specialOffer = (clone $baseQuery)
                ->where('special_offer', true)
                ->limit(10)
                ->get();

            $featured = (clone $baseQuery)
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
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product fetch error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
