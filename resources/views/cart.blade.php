@extends('layout')
@section('main')
    <!-- Cart Area Start -->
    <div class="cart-main-area pt-100px pb-100px">
        @if (count($carts) > 0)
            <div class="container">
                <div class="row">
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="fw-bold mb-0">
                            <i class="fa fa-shopping-cart me-2 text-primary"></i> Your Cart
                        </h3>
                        <span class="badge bg-primary ms-2 fs-6">{{ count($carts) }} items</span>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form action="#">
                            <div class="table-content table-responsive cart-table-content">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Until Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>@php
                                        $subTotal = 0;
                                        $total = 0;
                                    @endphp
                                        @foreach ($carts as $key => $cart)
                                            @php
                                                $subTotal = $cart['price'] * $cart['quantity'];
                                                $total += $cart['price'] * $cart['quantity'];
                                            @endphp
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href=""><img class="img-responsive ml-15px"
                                                            src="{{ asset('images/products/' . $cart['image']) }}"
                                                            alt="" /></a>
                                                </td>
                                                <td class="product-name"><a href="#">{{ $cart['product_name'] }}</a>
                                                </td>
                                                <td class="product-price-cart"><span class="amount">Rs.
                                                        {{ $cart['price'] }}</span>
                                                </td>
                                                <td class="product-quantity">
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box" type="text"
                                                            id="quantity_{{ $key }}"
                                                            onchange="CartQuantity('{{ $key }}', this.value)"
                                                            name="quantity" value="{{ $cart['quantity'] }}"
                                                            min="1" />
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">Rs. {{ $subTotal }}</td>
                                                <td class="product-remove">
                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <div class="cart-shiping-update">
                                            <a href="#">Continue Shopping</a>
                                        </div>
                                        <div class="cart-clear">
                                            <a href="#">Clear Shopping Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-lm-30px">
                                <div class="cart-tax">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                                    </div>
                                    <div class="tax-wrapper">
                                        <p>Enter your destination to get a shipping estimate.</p>
                                        <div class="tax-select-wrapper">
                                            <div class="tax-select">
                                                <label>
                                                    * Country
                                                </label>
                                                <select class="email s-email s-wid">
                                                    <option>Bangladesh</option>
                                                    <option>Albania</option>
                                                    <option>Åland Islands</option>
                                                    <option>Afghanistan</option>
                                                    <option>Belgium</option>
                                                </select>
                                            </div>
                                            <div class="tax-select">
                                                <label>
                                                    * Region / State
                                                </label>
                                                <select class="email s-email s-wid">
                                                    <option>Bangladesh</option>
                                                    <option>Albania</option>
                                                    <option>Åland Islands</option>
                                                    <option>Afghanistan</option>
                                                    <option>Belgium</option>
                                                </select>
                                            </div>
                                            <div class="tax-select mb-25px">
                                                <label>
                                                    * Zip/Postal Code
                                                </label>
                                                <input type="text" />
                                            </div>
                                            <button class="cart-btn-2" type="submit">Get A Quote</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-lm-30px">
                                <div class="discount-code-wrapper">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                                    </div>
                                    <div class="discount-code">
                                        <p>Enter your coupon code if you have one.</p>
                                        <form>
                                            <input type="text" required="" name="name" />
                                            <button class="cart-btn-2" type="submit">Apply Coupon</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 mt-md-30px">
                                <div class="grand-totall">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                    </div>
                                    <h5>Total products <span>Rs. {{ $total }}</span></h5>
                                    <div class="total-shipping">
                                        <h5>Total shipping</h5>
                                        <ul>
                                            <li><input type="radio" id="standard" name="shipping" value="standard" />
                                                Standard <span>Rs
                                                    200</span></li>
                                            <li><input type="radio" id="express" name="shipping" value="express" />
                                                Express <span>Rs.
                                                    300</span></li>
                                        </ul>
                                    </div>
                                    <h4 class="grand-totall-title" id="grandtotal">Grand Total <span>Rs . 260</span></h4>
                                    <a href="checkout.html">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Your cart is empty</h4>
                <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
                <a href="{{ url('/') }}">Start Shopping</a>
            </div>
        @endif
    </div>
    <!-- Cart Area End -->

    <script>
        const CartQuantity = async (id, quantity) => {
            let standard = document.getElementById('standard');
            let express = document.getElementById('express');
            let grandTotal = document.getElementById('grandtotal');

            try {
                const response = await fetch(`{{ url('/product/cart/quantity/') }}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                });
                const data = await response.json();
                console.log('Status:', response.status); // ← add this
                console.log('Data:', data); // ← add this
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endsection
