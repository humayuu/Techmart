<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    /**
     * JSON for header live search (GET /search?q=).
     * Uses the same DB rules as results() so suggestions match the results page and work without Scout.
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $like = '%'.$query.'%';

        $products = Product::query()
            ->where('status', 'active')
            ->where(function ($q) use ($like) {
                $q->where('product_name', 'like', $like)
                    ->orWhere('product_slug', 'like', $like)
                    ->orWhere('product_tags', 'like', $like);
            })
            ->orderBy('product_name')
            ->limit(8)
            ->get();

        return response()->json($products->map(function (Product $product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'slug' => $product->product_slug,
                'price' => (float) $product->price,
                'image' => $product->image_url,
                'url' => route('product.detail', $product->id),
            ];
        }));
    }

    /**
     * Full HTML results page with consistent product cards.
     */
    public function results(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        if (strlen($query) < 2) {
            $products = new LengthAwarePaginator([], 0, 16, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        } else {
            $products = Product::query()
                ->where('status', 'active')
                ->where(function ($q) use ($query) {
                    $like = '%'.$query.'%';
                    $q->where('product_name', 'like', $like)
                        ->orWhere('product_slug', 'like', $like)
                        ->orWhere('product_tags', 'like', $like);
                })
                ->orderBy('product_name')
                ->paginate(16)
                ->appends(['q' => $query]);
        }

        return view('search', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
