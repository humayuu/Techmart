<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

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

    /**
     * Function for Show Single Product Details
     */
    public function ProductDetails($id)
    {
        try {
            $product = Product::with(['category', 'brand'])
                ->find($id);

            return view('product_detail', compact('product'));

        } catch (Exception $e) {
            Log::error('Error in Fetch Single Product ', $e->getMessage());

            return redirect()->back();
        }
    }
}
