<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\CheckoutInfoRequest;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Mail\OrderPlacedMail;
use App\Models\Admin;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Notifications\NewOrderPlaced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Stripe\Charge;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    /**
     * For Checkout Page Add user added info in session
     */
    public function CheckOutInfo(CheckoutInfoRequest $request)
    {
        $request->session()->put('order_details', [
            'province' => $request->province,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'shipping_method' => $request->shipping_method,
            'coupon' => $request->coupon_code,
        ]);

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
    public function PlaceOrder(PlaceOrderRequest $request)
    {
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

        foreach ($carts as $line) {
            $product = Product::find($line['product_id'] ?? null);
            if (! $product || $product->status !== 'active') {
                return redirect()->route('cart')->with('error', 'A product in your cart is no longer available. Please update your cart.');
            }
            $need = (int) ($line['quantity'] ?? 0);
            if ($need < 1 || (int) $product->product_qty < $need) {
                return redirect()->route('cart')->with(
                    'error',
                    'Not enough stock for '.$product->product_name.'. Please update quantities and try again.'
                );
            }
        }

        $subTotal = collect($carts)->sum(fn ($c) => $c['price'] * $c['quantity']);
        $shippingCost = $orderDetails['shipping_method'] === 'express' ? 300 : 200;
        $appliedCoupon = session()->get('applied_coupon');
        $discountAmount = 0;
        $couponCode = null;

        if ($appliedCoupon) {
            $discountAmount = $subTotal * ($appliedCoupon['discount'] / 100);
            $couponCode = $appliedCoupon['coupon_code'];
        }

        $totalAmount = ($subTotal - $discountAmount) + $shippingCost;

        $transactionId = null;
        $paymentStatus = 'pending';

        if ($request->payment_method === 'stripe') {
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

                if ($charge->status !== 'succeeded') {
                    return redirect()->back()->with('error', 'Payment failed. Please try again.');
                }
                $transactionId = $charge->id;
                $paymentStatus = 'paid';

            } catch (CardException $e) {
                return redirect()->back()->with('error', 'Card declined: '.$e->getMessage());

            } catch (InvalidRequestException $e) {
                return redirect()->back()->with('error', 'Invalid payment request: '.$e->getMessage());

            } catch (ApiConnectionException $e) {
                return redirect()->back()->with('error', 'Network error. Please try again.');
            }
        }

        try {
            $order = DB::transaction(function () use (
                $request,
                $carts,
                $orderDetails,
                $provinceName,
                $cityName,
                $subTotal,
                $shippingCost,
                $discountAmount,
                $couponCode,
                $totalAmount,
                $paymentStatus,
                $transactionId
            ) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'payment_status' => $paymentStatus,
                    'transaction_id' => $transactionId,
                    'coupon_code' => $couponCode ?? null,
                    'discount_amount' => $discountAmount,
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
                    Product::where('id', $cart['product_id'])->decrement('product_qty', $cart['quantity']);
                }

                Notification::send(Admin::all(), new NewOrderPlaced($order));

                return $order;
            });
        } catch (\Throwable $e) {
            Log::error('Error in Place order '.$e->getMessage());

            return redirect()->back()->with('error', 'Place Order Failed');
        }

        try {
            Mail::to($request->email)->send(new OrderPlacedMail($order));
        } catch (\Throwable $e) {
            Log::error('Order mail failed: '.$e->getMessage());
        }

        session()->forget('cart');
        session()->forget('order_details');
        session()->forget('applied_coupon');
        session()->put('order_confirm', true);

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

        session()->forget('order_confirm');

        return view('thank-you');
    }
}
