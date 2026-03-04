@extends('layout')
@section('main')
    <!-- checkout area start -->
    <div class="checkout-area pt-100px pb-100px">
        <div class="container">
            <form method="POST" action="{{ route('place.order') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-6">
                                    <div class="billing-info mb-4">
                                        <label>Fullname</label>
                                        <input type="text" name="fullname" value="{{ Auth::user()->name }}" autofocus />
                                    </div>
                                    @error('fullname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-4">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" />
                                    </div>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info mb-4">
                                        <label>Email Address</label>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" />
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="billing-info mb-4">
                                        <label>Street Address</label>
                                        <input class="billing-address" name="address"
                                            placeholder="House number and street name" type="text" />
                                    </div>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="additional-info-wrap">
                                <h4>Additional information</h4>
                                <div class="additional-info">
                                    <label>Order notes</label>
                                    <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                        <div class="your-order-area">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                <div class="your-order-product-info">
                                    <div class="your-order-top">
                                        <ul>
                                            <li>Product</li>
                                            <li>Total</li>
                                        </ul>
                                    </div>
                                    <div class="your-order-middle">
                                        <ul>
                                            @foreach ($carts as $cart)
                                                <li><span class="order-middle-left">{{ $cart['product_name'] }} X
                                                        {{ $cart['quantity'] }}</span> <span class="order-price">Rs .
                                                        {{ $cart['price'] * $cart['quantity'] }}
                                                    </span></li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    <div class="your-order-bottom">
                                        <ul>
                                            <li class="your-order-shipping">Shipping Method : <span
                                                    class="text-danger fw-bold fs-4">{{ Str::ucfirst($orderDetails['shipping_method']) }}</span>
                                            </li>
                                            <li>Rs . {{ $shippingCost }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="your-order-total">
                                        <ul>
                                            <li class="order-total">Total</li>
                                            <li>Rs . {{ $total + $shippingCost }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div class="payment-method">
                                        <div class="payment-option">
                                            <input type="radio" name="payment_method" checked id="cod"
                                                value="cod">
                                            <label for="cod">
                                                <i class="fa-solid fa-truck-fast"></i>
                                                <span>Cash On Delivery</span>
                                            </label>
                                        </div>

                                        <div class="payment-option">
                                            <input type="radio" name="payment_method" id="stripe" value="stripe">
                                            <label for="stripe">
                                                <i class="fa-solid fa-credit-card"></i>
                                                <span>Pay with Card (Stripe)</span>
                                            </label>
                                        </div>

                                        <div id="stripe-card-fields" class="stripe-details-container">
                                            <div class="billing-info mb-3">
                                                <label class="form-label-sm">Card Number</label>
                                                <input type="text" class="form-control-sm"
                                                    placeholder="1234 5678 9101 1121">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="billing-info mb-0">
                                                        <label class="form-label-sm">Expiry</label>
                                                        <input type="text" class="form-control-sm" placeholder="MM/YY">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="billing-info mb-0">
                                                        <label class="form-label-sm">CVC</label>
                                                        <input type="text" class="form-control-sm" placeholder="123">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Place-order mt-25">
                                <button class="btn-imp">Place Order</button>

                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- checkout area end -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripeContainer = document.getElementById('stripe-card-fields');
            const radios = document.querySelectorAll('input[name="payment_method"]');

            function toggleStripe() {
                const selected = document.querySelector('input[name="payment_method"]:checked').value;
                stripeContainer.style.display = (selected === 'stripe') ? 'block' : 'none';
            }

            radios.forEach(radio => {
                radio.addEventListener('change', toggleStripe);
            });

            // Initialize on load
            toggleStripe();
        });
    </script>
@endsection
