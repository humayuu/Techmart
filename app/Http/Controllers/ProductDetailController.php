<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
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
                ->findOrFail($id);

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('status', 'active')
                ->take(4)
                ->get();

            return view('product_detail', compact('product', 'relatedProducts'));

        } catch (Exception $e) {
            Log::error('Error in Fetch Single Product: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Function for Show Category wise product
     */
    public function CategoryWiseProduct($id)
    {
        try {
            $category = Category::findOrFail($id);
            $products = Product::with(['brand', 'category'])
                ->where('category_id', $id)
                ->paginate(10);

            return view('category_wise', compact('products', 'category'));
        } catch (Exception $e) {
            Log::error('Error in Fetch Category wise product: '.$e->getMessage());

            return redirect()->back()->with('error', 'Error in Fetch Category wise product');
        }
    }

    /**
     * Function for Show brand Wise Product
     */
    public function BrandWiseProduct($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $products = Product::with(['category', 'brand'])
                ->where('brand_id', $id)
                ->paginate(10);

            return view('brand_wise', compact('products', 'brand'));

        } catch (Exception $e) {
            Log::error('Error in fetch Brand Wise Product '.$e->getMessage());

            return redirect()->back()->with('error', 'Error in fetch Brand Wise Product');
        }
    }
}
