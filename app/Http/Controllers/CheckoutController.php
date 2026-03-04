<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * For Checkout Page Add user added info in session
     */
    public function CheckOutInfo(Request $request)
    {
        $request->validate([
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'shipping_method' => 'required|string',
            'coupon_code' => 'nullable|string|max:100',
        ]);

        $orderDetails = [
            'province' => $request->province,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'shipping_method' => $request->shipping_method,
            'coupon' => $request->coupon_code,
        ];

        $request->session()->put('order_details', $orderDetails);

        return redirect()->route('checkout.page');
    }

    /**
     * For Redirect to Authenticated user to checkout Page
     */
    public function CheckoutPage()
    {
        $carts = session()->get('cart', []);
        $orderDetails = session()->get('order_details', []);

        if (! $carts || count($carts) === 0) {
            return redirect()->route('cart')->with('message', 'Please select an item to access the checkout page.');
        } elseif (empty($orderDetails)) {
            return redirect()->route('cart')->with('message', 'Please fill out all required information.');
        }

        $total = collect($carts)->sum(fn ($c) => $c['price'] * $c['quantity']);
        $shippingCost = $orderDetails['shipping_method'] === 'express' ? 300 : 200;

        return view('checkout', compact('carts', 'orderDetails', 'total', 'shippingCost'));
    }

    /**
     * For Place Order Stripe or Cash on Delivery
     */
    public function PlaceOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $carts = session()->get('cart', []);
            $subTotal = 0;
            foreach ($carts as $cart) {
                $subTotal += $cart['price'] * $cart['quantity'];
            }
            $orderDetails = session()->get('order_details', []);
            $shippingCost = $orderDetails['shipping_method'] === 'express' ? 300 : 200;
            $totalAmount = $subTotal + $shippingCost;

            $order = Order::create([
                'user_id' => Auth::id(),
                'payment_method' => $request->payment_method,
                'coupon_code' => $orderDetails['coupon'],
                'subtotal' => $subTotal,
                'shipping_amount' => $shippingCost,
                'total_amount' => $totalAmount,
                'shipping_method' => $orderDetails['shipping_method'],
                'province' => $orderDetails['province'],
                'city' => $orderDetails['city'],
                'address' => $request->address,
                'zip' => $orderDetails['zipcode'],
                'notes' => $request->note,

            ]);

            foreach ($carts as $cart) {
                $order->orderProducts()->create([
                    'product_id' => $cart['product_id'],
                    'product_name' => $cart['product_name'],
                    'product_image' => $cart['image'],
                    'quantity' => $cart['quantity'],
                    'unit_price' => $cart['price'],
                    'sub_total' => $cart['price'] * $cart['quantity'],
                ]);
            }

            DB::commit();

            session()->forget('cart');
            session()->forget('order_details');
            session()->put('order_confirm', true);

            return redirect()->route('thank.you.page');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error in Place order '.$e->getMessage());

            return redirect()->back()->with('error', 'Place Order Failed');

        }

    }

    /**
     * For Redirect to Thanks page after place order
     */
    public function ThanksPage()
    {
        if (! session()->has('order_confirm')) {
            return redirect(url('/'));
        }

        // One Time Only
        session()->forget('order_confirm');

        return view('thank-you');

    }
}
