@extends('layout')
@section('main')
    <!-- Cart Area Start -->
    <div class="cart-main-area pt-100px pb-100px">
        @if (session('message'))
            <span class="h5 text-danger d-block text-center mt-2">
                {{ session('message') }}
            </span>
        @endif
        <div class="container">
            <div class="row">
                <div class="d-flex align-items-center mb-4">
                    <h3 class="fw-bold mb-0">
                        <i class="fa fa-shopping-cart me-2 text-primary"></i> Your Cart
                    </h3>
                    <span class="badge bg-primary ms-2 fs-6" id="cartCount"></span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="{{ url('/') }}">Continue Shopping</a>
                                </div>
                                <div class="cart-clear">
                                    <button onclick="ClearCart()">Clear Shopping Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('checkout.info') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-lm-30px">
                                <div class="cart-tax">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Estimate Shipping And Tax</h4>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-muted">Enter your destination to get a shipping estimate.</p>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">* Province</label>
                                                <select class="form-select" name="province"
                                                    onchange="SelectCity(this.value)">
                                                    <option value="" disabled selected>Select a Province</option>
                                                    @forelse ($provinces as $province)
                                                        <option value="{{ $province->id }}">
                                                            {{ $province->name }}
                                                        </option>
                                                    @empty
                                                        <option disabled>No Record Found</option>
                                                    @endforelse
                                                </select>
                                                @error('province')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">* City</label>
                                                <select class="form-select" name="city" id="allCities">
                                                    <option value="" disabled selected>Select a Province first
                                                    </option>
                                                </select>
                                                @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">* Zip Code</label>
                                                <input type="text" name="zipcode" class="form-control"
                                                    placeholder="Enter zip code" />
                                                @error('zipcode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                        <input type="text" name="coupon_code" />
                                        <button class="cart-btn-2" type="submit">Apply Coupon</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12 mt-md-30px">
                                <div class="grand-totall">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                    </div>
                                    <h5>Total products <span id="producttotal"></span></h5>
                                    <div class="total-shipping">
                                        <h5>Select Shipping Method</h5>
                                        <ul>
                                            <li>
                                                <input type="radio" id="standard" name="shipping_method"
                                                    value="standard" />
                                                Standard <span>Rs 200</span>
                                            </li>
                                            <li>
                                                <input type="radio" id="express" name="shipping_method"
                                                    value="express" />
                                                Express <span>Rs. 300</span>
                                            </li>
                                        </ul>
                                        @error('shipping_method')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <h4 class="grand-totall-title">Grand Total <span id="grandtotal"></span></h4>
                                    @auth
                                        <button class="btn-imp">Proceed to Checkout</button>
                                    @else
                                        <a href="{{ route('login') }}">Please log in to proceed to checkout</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Empty Cart State -->
    <div class="text-center py-5 mt-5" style="display: none;">
        <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">Your cart is empty</h4>
        <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
        <a href="{{ url('/') }}">Start Shopping</a> <br>

    </div>
    <!-- Cart Area End -->
@endsection

@section('scripts')
    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';

        const loadCart = async () => {
            let count = document.getElementById('cartCount');
            let tbodyEl = document.getElementById('cartBody');
            let gTotal = document.getElementById('grandtotal');
            let pTotal = document.getElementById('producttotal');
            let standardShip = document.getElementById('standard');
            let expressShip = document.getElementById('express');

            tbodyEl.innerHTML = '';

            const response = await fetch(`{{ url('product/all/cart') }}`);
            let data = await response.json();
            const carts = data.carts;
            const cartCount = data.cartCount;
            count.innerHTML = `items ${cartCount}`;

            if (!carts || Object.keys(carts).length === 0) {
                document.querySelector('.text-center').style.display = 'block';
                document.querySelector('.cart-main-area').style.display = 'none';
                return;
            }

            let productTotal = 0;

            Object.values(carts).forEach((cart) => {
                productTotal += cart.price * cart.quantity;

                tbodyEl.innerHTML += `
                    <tr>
                        <td class="product-thumbnail">
                            <a href=""><img class="img-responsive ml-15px" src="/images/products/${cart.image}" alt="" /></a>
                        </td>
                        <td class="product-name"><a href="#">${cart.product_name}</a></td>
                        <td class="product-price-cart"><span class="amount">Rs. ${cart.price}</span></td>
                        <td class="product-quantity">
                            <div>
                                <input
                                    type="number"
                                    name="quantity"
                                    onchange="CartQty(${cart.product_id}, this.value, ${cart.price}, this)"
                                    value="${cart.quantity}"
                                    min="1"
                                    style="width:75px; border:none"
                                />
                            </div>
                        </td>
                        <td class="product-subtotal">Rs. ${cart.price * cart.quantity}</td>
                        <td class="product-remove">
                            <button onclick="CartRemove(${cart.product_id}, this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>`;
            });

            pTotal.innerHTML = `Rs. ${productTotal}`;

            const calculateGrandTotal = (total) => {
                let shipping = 0;
                if (standardShip.checked) shipping = 200;
                else if (expressShip.checked) shipping = 300;
                gTotal.innerHTML = `Rs. ${total + shipping}`;
            };

            calculateGrandTotal(productTotal);

            standardShip.addEventListener('change', () => calculateGrandTotal(productTotal));
            expressShip.addEventListener('change', () => calculateGrandTotal(productTotal));
        };

        const ClearCart = async () => {
            const response = await fetch(`{{ url('product/cart/clear') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            let data = await response.json();
            if (!data.status) return;

            document.querySelector('.text-center').style.display = 'block';
            document.querySelector('.cart-main-area').style.display = 'none';
        };

        const CartQty = async (productId, qty, price, inputEl) => {
            const response = await fetch(`{{ url('product/cart/quantity') }}/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    quantity: qty
                })
            });

            const data = await response.json();

            if (data.status) {
                const row = inputEl.closest('tr');
                const subtotalEl = row.querySelector('.product-subtotal');
                subtotalEl.innerHTML = `Rs. ${price * qty}`;

                // Recalculate product total from all rows
                let productTotal = 0;
                document.querySelectorAll('tr').forEach(tr => {
                    const qtyInput = tr.querySelector('input[name="quantity"]');
                    const priceEl = tr.querySelector('.product-price-cart .amount');
                    if (qtyInput && priceEl) {
                        const rowPrice = parseFloat(priceEl.innerText.replace('Rs. ', ''));
                        productTotal += rowPrice * parseInt(qtyInput.value);
                    }
                });

                document.getElementById('producttotal').innerHTML = `Rs. ${productTotal}`;

                let shipping = 0;
                if (document.getElementById('standard').checked) shipping = 200;
                else if (document.getElementById('express').checked) shipping = 300;
                document.getElementById('grandtotal').innerHTML = `Rs. ${productTotal + shipping}`;
            }
        };

        const CartRemove = async (id, buttonEl) => {
            const response = await fetch(`{{ url('product/cart/remove') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const data = await response.json();

            if (data.status) {
                const row = buttonEl.closest('tr');
                row.remove();

                // Recalculate product total
                let productTotal = 0;
                document.querySelectorAll('tr').forEach(tr => {
                    const qtyInput = tr.querySelector('input[name="quantity"]');
                    const priceEl = tr.querySelector('.product-price-cart .amount');
                    if (qtyInput && priceEl) {
                        const rowPrice = parseFloat(priceEl.innerText.replace('Rs. ', ''));
                        productTotal += rowPrice * parseInt(qtyInput.value);
                    }
                });

                document.getElementById('producttotal').innerHTML = `Rs. ${productTotal}`;
                document.getElementById('cartCount').innerHTML = `items ${data.cart_count}`;

                let shipping = 0;
                if (document.getElementById('standard').checked) shipping = 200;
                else if (document.getElementById('express').checked) shipping = 300;
                document.getElementById('grandtotal').innerHTML = `Rs. ${productTotal + shipping}`;

                if (data.cart_count === 0) {
                    document.querySelector('.text-center').style.display = 'block';
                    document.querySelector('.cart-main-area').style.display = 'none';
                }
            }
        };

        // Fetch cities for selected province
        const SelectCity = async (provinceId) => {
            const cities = document.getElementById('allCities');

            const response = await fetch(`{{ url('product/cart/all/cities') }}/${provinceId}`);
            const data = await response.json();

            if (data.cities.length >= 1) {
                cities.innerHTML = '<option value="" disabled selected>Select a City</option>';
                data.cities.forEach(city => {
                    cities.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            } else {
                cities.innerHTML = '<option value="" disabled selected>No City Available</option>';
            }
        };

        loadCart();
    </script>
@endsection
