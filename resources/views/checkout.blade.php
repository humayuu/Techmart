@extends('layout')
@section('main')
    <!-- Add in <head> or before closing </body> -->
    <script src="https://js.stripe.com/v3/"></script>

    <div class="checkout-area pt-100px pb-100px">
        <div class="container">
            <form method="POST" action="{{ route('place.order') }}" id="checkout-form">
                @csrf

                {{-- Hidden token field — Stripe.js fills this --}}
                <input type="hidden" name="stripe_token" id="stripe_token">

                <div class="row">
                    <div class="col-lg-7">
                        {{-- your billing fields stay the same --}}
                        <div class="billing-info-wrap">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="billing-info mb-4">
                                        <label>Fullname</label>
                                        <input type="text" name="fullname" value="{{ Auth::user()->name }}" />
                                    </div>
                                    @error('fullname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <div class="billing-info mb-4">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" />
                                    </div>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
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
                                        <input name="address" placeholder="House number and street name" type="text" />
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
                                    <textarea name="note" placeholder="Notes about your order"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="your-order-area">
                            <h3>Your order</h3>
                            <div class="your-order-wrap gray-bg-4">
                                {{-- order summary stays the same --}}
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
                                                <li>
                                                    <span class="order-middle-left">{{ $cart['product_name'] }} X
                                                        {{ $cart['quantity'] }}</span>
                                                    <span class="order-price">Rs.
                                                        {{ $cart['price'] * $cart['quantity'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="your-order-bottom">
                                        <ul>
                                            <li>Shipping: {{ Str::ucfirst($orderDetails['shipping_method']) }}</li>
                                            <li>Rs. {{ $shippingCost }}</li>
                                        </ul>
                                    </div>
                                    <div class="your-order-total">
                                        <ul>
                                            <li class="order-total">Total</li>
                                            <li>Rs. {{ $total + $shippingCost }}</li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Payment Methods --}}
                                <div class="payment-method">
                                    <div class="payment-option">
                                        <input type="radio" name="payment_method" checked id="cod" value="cod">
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
                                    <div id="stripe-card-fields" style="display:none;" class="mt-3">
                                        <div class="billing-info mb-3">
                                            <label>Card Details</label>
                                            <div id="card-element">
                                            </div>
                                            <div id="card-errors" class="text-danger mt-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="Place-order mt-25">
                                <button type="submit" class="btn-imp-2" id="place-order-btn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Show/hide stripe fields
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('stripe-card-fields').style.display =
                    this.value === 'stripe' ? 'block' : 'none';
            });
        });

        // Handle form submit
        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (paymentMethod !== 'stripe') return; // COD — just submit normally

            e.preventDefault();

            const btn = document.getElementById('place-order-btn');
            btn.disabled = true;
            btn.textContent = 'Processing...';

            const {
                token,
                error
            } = await stripe.createToken(cardElement);

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                btn.disabled = false;
                btn.textContent = 'Place Order';
            } else {
                document.getElementById('stripe_token').value = token.id;
                this.submit();
            }
        });
    </script>
@endsection
