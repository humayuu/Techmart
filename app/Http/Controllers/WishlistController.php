<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * For Add To Wishlist & create Session
     */
    public function addToWishlist($id)
    {
        $id = (int) $id;
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);
        $selling = (float) ($product->selling_price ?? 0);
        $discount = (float) ($product->discount_price ?? 0);
        $price = max(0.0, $selling - $discount);

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
    }

    /**
     * For View All Wishlist
     */
    public function allWishlistData()
    {
        $wishlist = session()->get('wishlist', []);

        return response()->json([
            'status' => true,
            'wishlist' => $wishlist,
        ], 200);
    }

    /**
     * For item Remove From Wishlist
     */
    public function wishlistRemove($id)
    {
        $id = (int) $id;
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);

            session()->put('wishlist', $wishlist);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item removed from your wishlist.',
            'wishlist_count' => count($wishlist),
        ], 200);
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
        $wishlist = session()->get('wishlist', []);

        return response()->json([
            'status' => true,
            'wishlist' => $wishlist,
            'wishlistCount' => count($wishlist),
        ], 200);
    }
}
