<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
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
                'product_name' => $product->product_name,
                'product_thumbnail' => $product->product_thumbnail,
                'cart_count' => count($cart),
                'quantity' => $cart[$id]['quantity'],
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

    /**
     * For Redirect to Cart Page
     */
    public function Cart()
    {

        return view('cart');
    }

    /**
     * For Redirect to Cart Page
     */
    public function AllCartData()
    {
        try {
            $carts = session()->get('cart', []);

            $total = 0;
            foreach ($carts as $cart) {
                $total += $cart['price'] * $cart['quantity'];
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully Fetch All Cart Data',
                'carts' => $carts,
                'cartCount' => count($carts),
                'total' => $total,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error in fetch All Cart Data '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in fetch All Cart Data ',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For handle Cart Quantity
     */
    public function CartQuantity(Request $request, $id)
    {

        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);
            $cart = session()->get('cart', []);

            // Update Cart Quantity and Totals
            $cart[$id]['quantity'] = $request->quantity;
            $subTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
            session()->put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Cart updated successfully',
                'quantity' => $cart[$id]['quantity'],
                'subTotal' => $subTotal,
                'cart' => $cart,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error in update cart quantity '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error in update cart quantity',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * For Cart Clear
     */
    public function CartClear()
    {
        session()->forget('cart');

        return response()->json([
            'status' => true,
            'message' => 'Successfully clear cart',
        ], 200);
    }
}
