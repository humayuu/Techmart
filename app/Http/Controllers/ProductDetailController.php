<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    /**
     * Function for filter product
     */
    public function ProductFilter()
    {
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
    }

    /**
     * Function for Show Single Product Details
     */
    public function ProductDetails($id)
    {
        $product = Product::with(['category', 'brand'])
            ->findOrFail($id);

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('product_detail', compact('product', 'relatedProducts'));
    }

    /**
     * Function for Show Category wise product
     */
    public function CategoryWiseProduct($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::with(['brand', 'category'])
            ->where('category_id', $id)
            ->paginate(10);

        return view('category_wise', compact('products', 'category'));
    }

    /**
     * Function for Show brand Wise Product
     */
    public function BrandWiseProduct($id)
    {
        $brand = Brand::findOrFail($id);
        $products = Product::with(['category', 'brand'])
            ->where('brand_id', $id)
            ->paginate(10);

        return view('brand_wise', compact('products', 'brand'));
    }

    /**
     * Function for Show Category Wise Product Sorting
     */
    public function CategoryWiseSorting($id)
    {
        $baseQuery = Product::with(['brand', 'category'])
            ->where('category_id', $id);

        $ascOrder = (clone $baseQuery)
            ->orderBy('product_name', 'ASC')
            ->get();

        $descOrder = (clone $baseQuery)
            ->orderBy('product_name', 'DESC')
            ->get();

        $ascPrice = (clone $baseQuery)
            ->orderBy(DB::raw('(selling_price - discount_price)'), 'ASC')
            ->get();

        $descPrice = (clone $baseQuery)
            ->orderBy(DB::raw('(selling_price - discount_price)'), 'DESC')
            ->get();

        $latest = (clone $baseQuery)
            ->latest()
            ->get();

        $oldest = (clone $baseQuery)
            ->oldest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fetch Category Wise Product',
            'asc' => $ascOrder,
            'desc' => $descOrder,
            'ascPrice' => $ascPrice,
            'descPrice' => $descPrice,
            'latest' => $latest,
            'oldest' => $oldest,
        ], 200);
    }

    /**
     * Function for Show Category Wise Product Sorting
     */
    public function BrandWiseSorting($id)
    {
        $baseQuery = Product::with(['brand', 'category'])
            ->where('brand_id', $id);

        $ascOrder = (clone $baseQuery)
            ->orderBy('product_name', 'ASC')
            ->get();

        $descOrder = (clone $baseQuery)
            ->orderBy('product_name', 'DESC')
            ->get();

        $ascPrice = (clone $baseQuery)
            ->orderBy(DB::raw('(selling_price - discount_price)'), 'ASC')
            ->get();

        $descPrice = (clone $baseQuery)
            ->orderBy(DB::raw('(selling_price - discount_price)'), 'DESC')
            ->get();

        $latest = (clone $baseQuery)
            ->latest()
            ->get();

        $oldest = (clone $baseQuery)
            ->oldest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fetch Brand Wise Product',
            'asc' => $ascOrder,
            'desc' => $descOrder,
            'ascPrice' => $ascPrice,
            'descPrice' => $descPrice,
            'latest' => $latest,
            'oldest' => $oldest,
        ], 200);
    }
}
