<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * For Add To Cart & create Session
     */
    public function AddToCart($id)
    {
        try {

            $product = Product::findOrFail($id);
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];
            } else {
                // Add new product to cart
                $price = $product->selling_price - $product->discount_price;
                $cart[$id] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'image' => $product->product_thumbnail,
                    'price' => $price,
                    'quantity' => 1,
                    'subtotal' => $price * 1,
                ];
            }

            // Save updated cart back to session
            session()->put('cart', $cart);

            return response()->json([
                'status' => true,
                'product_thumbnail' => $product->product_thumbnail,
                'cart_count' => count($cart),
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in Add to Cart '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in add to cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For View All Carts
     */
    public function ViewAllCart()
    {
        try {
            $carts = session()->get('cart', []);

            return response()->json([
                'status' => true,
                'carts' => $carts,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in Fetch All Carts '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in Fetch All Carts',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For item Remove From Cart
     */
    public function CartRemove($id)
    {
        try {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);

                session()->put('cart', $cart);
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully Remove From Cart',
                'cart_count' => count($cart),
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in remove item from cart '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in remove item from cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
