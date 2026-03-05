<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use App\Models\City;
use App\Models\Order;
use App\Models\Province;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Stripe;

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
            if (empty($carts)) {
                return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
            $orderDetails = session()->get('order_details', []);
            if (empty($orderDetails)) {
                return redirect()->route('cart')->with('error', 'Session expired. Please try again.');
            }

            $provinceName = Province::find($orderDetails['province'])->name ?? $orderDetails['province'];
            $cityName = City::find($orderDetails['city'])->name ?? $orderDetails['city'];
            $subTotal = collect($carts)->sum(fn ($c) => $c['price'] * $c['quantity']);
            $shippingCost = $orderDetails['shipping_method'] === 'express' ? 300 : 200;
            $totalAmount = $subTotal + $shippingCost;

            // ============================================
            // STRIPE PAYMENT
            // ============================================
            $transactionId = null;
            $paymentStatus = 'pending'; // COD default
            if ($request->payment_method === 'stripe') {

                // Make sure token came from the form
                if (! $request->stripe_token) {
                    return redirect()->back()->with('error', 'Payment token missing. Please try again.');
                }

                Stripe::setApiKey(config('services.stripe.secret'));

                try {
                    $charge = Charge::create([
                        'amount' => $totalAmount * 100,
                        'currency' => 'pkr',
                        'source' => $request->stripe_token,
                        'description' => 'Order by User #'.Auth::id(),
                    ]);

                    // Payment failed (shouldn't normally reach here, exceptions handle it)
                    if ($charge->status !== 'succeeded') {
                        return redirect()->back()->with('error', 'Payment failed. Please try again.');
                    }
                    $transactionId = $charge->id;
                    $paymentStatus = 'paid';

                } catch (\Stripe\Exception\CardException $e) {
                    // Card was declined
                    return redirect()->back()->with('error', 'Card declined: '.$e->getMessage());

                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    return redirect()->back()->with('error', 'Invalid payment request: '.$e->getMessage());

                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    return redirect()->back()->with('error', 'Network error. Please try again.');
                }
            }
            // ============================================

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'coupon_code' => $orderDetails['coupon'] ?? null,
                'subtotal' => $subTotal,
                'shipping_amount' => $shippingCost,
                'total_amount' => $totalAmount,
                'shipping_method' => $orderDetails['shipping_method'],
                'province' => $provinceName,
                'city' => $cityName,
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

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error in Place order '.$e->getMessage());

            return redirect()->back()->with('error', 'Place Order Failed');
        }

        try {
            Mail::to($request->email)->send(new OrderPlacedMail($order));
        } catch (Exception $e) {
            Log::error('Order mail failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Order mail Failed');
        }

        return redirect()->route('thank.you.page');

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
