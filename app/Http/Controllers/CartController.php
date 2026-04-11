<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\ApplyCouponRequest;
use App\Http\Requests\Cart\UpdateCartQuantityRequest;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Final unit price (matches storefront: selling_price minus discount amount).
     */
    protected function cartUnitPrice(Product $product): float
    {
        $selling = (float) ($product->selling_price ?? 0);
        $discount = (float) ($product->discount_price ?? 0);

        return max(0.0, $selling - $discount);
    }

    /**
     * For Add To Cart & create Session
     *
     * First add puts qty 1. If the line already exists, we return status "confirm"
     * until the client calls again with ?confirm=1 so the user can cancel without
     * changing quantity.
     */
    public function AddToCart(Request $request, $id)
    {
        $id = (int) $id;
        if ($id < 1) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid product.',
            ], 422);
        }

        $product = Product::findOrFail($id);
        $key = (string) $product->id;

        if ($product->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'This product is not available.',
            ], 422);
        }

        $cart = session()->get('cart', []);
        $stock = max(0, (int) $product->product_qty);
        $price = $this->cartUnitPrice($product);
        $confirmIncrease = $request->boolean('confirm');
        $incremented = false;

        if (isset($cart[$key])) {
            if (! $confirmIncrease) {
                return response()->json([
                    'status' => 'confirm',
                    'already_in_cart' => true,
                    'quantity' => (int) $cart[$key]['quantity'],
                    'product_name' => $product->product_name,
                    'product_thumbnail' => $product->product_thumbnail,
                    'cart_count' => count($cart),
                ], 200);
            }

            $currentQty = (int) $cart[$key]['quantity'];
            $newQty = $currentQty + 1;

            if ($stock < 1 || $newQty > $stock) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not enough stock available.',
                    'cart_count' => count($cart),
                ], 422);
            }

            $cart[$key]['quantity'] = $newQty;
            $cart[$key]['price'] = $price;
            $cart[$key]['subtotal'] = $price * $newQty;
            $incremented = true;
        } else {
            if ($stock < 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not enough stock available.',
                    'cart_count' => count($cart),
                ], 422);
            }

            $cart[$key] = [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'image' => $product->product_thumbnail,
                'price' => $price,
                'quantity' => 1,
                'subtotal' => $price,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'product_name' => $product->product_name,
            'product_thumbnail' => $product->product_thumbnail,
            'cart_count' => count($cart),
            'quantity' => $cart[$key]['quantity'],
            'incremented' => $incremented,
        ], 200);
    }

    /**
     * For View All Carts
     */
    public function ViewAllCart()
    {
        $carts = session()->get('cart', []);

        return response()->json([
            'status' => true,
            'carts' => $carts,
        ], 200);
    }

    /**
     * For item Remove From Cart
     */
    public function CartRemove($id)
    {
        $cart = session()->get('cart', []);
        $id = (string) $id;

        if (! isset($cart[$id])) {
            return response()->json([
                'status' => false,
                'message' => 'Item is not in your cart.',
                'cart_count' => count($cart),
            ], 404);
        }

        unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Successfully Remove From Cart',
            'cart_count' => count($cart),
        ], 200);
    }

    /**
     * For Redirect to Cart Page
     */
    public function Cart()
    {
        $provinces = Province::all();
        $cities = City::all();

        return view('cart', compact('provinces', 'cities'));
    }

    /**
     * For Redirect to Cart Page
     */
    public function AllCartData()
    {
        $carts = session()->get('cart', []);
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['subtotal'];
        }

        $appliedCoupon = session()->get('applied_coupon', null);

        return response()->json([
            'status' => true,
            'carts' => $carts,
            'cartCount' => count($carts),
            'total' => $total,
            'applied_coupon' => $appliedCoupon,
        ], 200);
    }

    /**
     * For Cart Quantity
     */
    public function CartQuantity(UpdateCartQuantityRequest $request, $id)
    {
        $cart = session()->get('cart', []);
        $id = (string) $id;

        if (! isset($cart[$id])) {
            return response()->json([
                'status' => false,
                'message' => 'Item is not in your cart.',
            ], 404);
        }

        $product = Product::find($id);
        if (! $product || $product->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'This product is not available.',
            ], 422);
        }

        $qty = (int) $request->validated('quantity');
        $stock = max(0, (int) $product->product_qty);
        if ($qty > $stock) {
            return response()->json([
                'status' => false,
                'message' => 'Not enough stock available.',
                'max_qty' => $stock,
            ], 422);
        }

        $price = $this->cartUnitPrice($product);
        $cart[$id]['quantity'] = $qty;
        $cart[$id]['price'] = $price;
        $cart[$id]['subtotal'] = $price * $qty;
        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Successfully Update Cart Quantity',
            'line_subtotal' => $cart[$id]['subtotal'],
            'unit_price' => $price,
            'quantity' => $qty,
        ]);
    }

    /**
     * For Cart Clear
     */
    public function CartClear()
    {
        session()->forget('cart');
        session()->forget('applied_coupon');

        return response()->json([
            'status' => true,
            'message' => 'Successfully clear cart',
        ], 200);
    }

    /**
     * Fetch All Active Cities for a Specific Province
     */
    public function AllCities($id)
    {
        $province = Province::with('cities')->findOrFail($id);

        $availableCities = $province->cities->where('is_active', 1)->values();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fetch All Cities',
            'cities' => $availableCities,
        ], 200);
    }

    /**
     * For Apply Coupon
     */
    public function ApplyCoupon(ApplyCouponRequest $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_code)
            ->where('status', 'active')
            ->whereDate('valid_until', '>=', Carbon::today())
            ->first();

        if (! $coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or Expired Coupon code',
            ], 422);
        }

        $carts = session()->get('cart', []);
        if (count($carts) === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Your cart is empty.',
            ], 422);
        }

        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['subtotal'];
        }

        $discountAmount = $total * ($coupon->coupon_discount / 100);
        $newTotal = $total - $discountAmount;

        session()->put('applied_coupon', [
            'coupon_code' => $coupon->coupon_name,
            'discount' => $coupon->coupon_discount,
            'discount_amount' => $discountAmount,
            'new_total' => $newTotal,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $coupon->coupon_discount,
            'discount_amount' => $discountAmount,
            'original_total' => $total,
            'new_total' => $newTotal,
        ]);
    }

    /**
     * For Remove Coupon
     */
    public function RemoveCoupon()
    {
        session()->forget('applied_coupon');

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully',
        ]);
    }
}
