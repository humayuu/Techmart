<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    /**
     * For Add To Wishlist & create Session
     */
    public function addToWishlist($id)
    {
        try {
            $product = Product::findOrFail($id);
            $wishlist = session()->get('wishlist', []);
            $price = $product->selling_price - $product->discount_price;

            if (! isset($wishlist[$id])) {
                $wishlist[$id] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'image' => $product->product_thumbnail,
                    'price' => $price,
                    'quantity' => 1,
                    'subtotal' => $price,
                ];
                session()->put('wishlist', $wishlist);
                $status = 'added';
            } else {
                $status = 'already_in_wishlist';
            }

            return response()->json([
                'status' => $status,
                'product_name' => $product->product_name,
                'image' => $product->product_thumbnail,
                'wishlist_count' => count($wishlist),
            ], 200);

        } catch (Exception $e) {
            Log::error('AddToWishlist Error: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Could not add product to wishlist.',
            ], 500);
        }
    }

    /**
     * For View All Wishlist
     */
    public function allWishlistData()
    {
        try {
            $wishlist = session()->get('wishlist', []);

            return response()->json([
                'status' => true,
                'wishlist' => $wishlist,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in Fetch All wishlist '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in Fetch All wishlist',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For item Remove From Wishlist
     */
    public function wishlistRemove($id)
    {
        try {
            $wishlist = session()->get('wishlist', []);

            if (isset($wishlist[$id])) {
                unset($wishlist[$id]);

                session()->put('wishlist', $wishlist);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully Remove From Cart',
                'wishlist_count' => count($wishlist),
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in remove item from wishlist '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in remove item from wishlist',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For View All Wishlist
     */
    public function wishlist()
    {
        $wishlist = session()->get('wishlist', []);

        return view('wishlist', compact('wishlist'));
    }

    /**
     * For All Wishlist Data
     */
    public function wishlistData()
    {
        try {
            $wishlist = session()->get('wishlist', []);

            return response()->json([
                'status' => true,
                'wishlist' => $wishlist,
                'wishlistCount' => count($wishlist),
            ], 200);

        } catch (Exception $e) {
            Log::error('Error in fetch All Wishlist Data '.$e->getMessage());

            return response()->json(['status' => false, 'message' => 'Error'], 500);
        }
    }
}
