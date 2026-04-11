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

                            <div class="col-lg-4 col-md-6 mb-lm-30px" id="coupon-div">
                                <div class="discount-code-wrapper">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Use Coupon Code</h4>
                                    </div>
                                    <div class="discount-code">
                                        <p>Enter your coupon code if you have one.</p>
                                        <input type="text" id="coupon_code" name="coupon_code" />
                                        <a type="button" class="cart-btn-2" id="couponbtn" onclick="ApplyCoupon()">Apply
                                            Coupon</a>
                                        <a type="button" style="display:none;" class="cart-btn-2" id="removecoupon"
                                            onclick="RemoveCoupon()">Remove Coupon</a>
                                    </div>
                                    <span class="text-danger" id="coupon_message"></span>
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
    <div id="empty-cart-state" class="text-center py-5 mt-5" style="display: none;">
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
        let appliedCoupon = null;

        const calculateGrandTotal = (productTotal) => {
            let shipping = 0;
            if (document.getElementById('standard').checked) shipping = 200;
            else if (document.getElementById('express').checked) shipping = 300;

            let discount = 0;
            if (appliedCoupon) {
                discount = productTotal * (appliedCoupon.discount / 100);
            }

            const grand = (productTotal - discount) + shipping;
            document.getElementById('grandtotal').innerHTML = `Rs. ${Math.round(grand)}`;
        };
        const recalculateProductTotal = () => {
            let productTotal = 0;
            document.querySelectorAll('#cartBody tr').forEach(tr => {
                const qtyInput = tr.querySelector('input[name="quantity"]');
                const priceEl = tr.querySelector('.product-price-cart .amount');
                if (qtyInput && priceEl) {
                    const rowPrice = parseFloat(priceEl.innerText.replace('Rs. ', ''));
                    productTotal += rowPrice * parseInt(qtyInput.value, 10);
                }
            });
            return productTotal;
        };

        const escapeHtml = (s) => {
            const d = document.createElement('div');
            d.textContent = s == null ? '' : String(s);
            return d.innerHTML;
        };

        const cartPageQtyChange = (productId, unitPrice, delta, btnEl) => {
            const tr = btnEl.closest('tr');
            if (!tr) return;
            const input = tr.querySelector('input[name="quantity"]');
            if (!input) return;
            let v = parseInt(input.value, 10) || 1;
            const next = v + delta;
            if (next < 1) return;
            input.value = next;
            CartQty(productId, String(next), unitPrice, input);
        };

        const loadCart = async () => {
            let count = document.getElementById('cartCount');
            let tbodyEl = document.getElementById('cartBody');
            let pTotal = document.getElementById('producttotal');
            let standardShip = document.getElementById('standard');
            let expressShip = document.getElementById('express');

            tbodyEl.innerHTML = '';

            const response = await fetch(`{{ url('product/all/cart') }}`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
            let data = await response.json().catch(() => ({}));

            if (!response.ok || !data.status) {
                tbodyEl.innerHTML = '';
                if (typeof AllCarts === 'function') await AllCarts();
                return;
            }

            const carts = data.carts || {};
            const cartCount =
                typeof data.cartCount === 'number' ? data.cartCount : Object.keys(carts).length;
            count.innerHTML = `items ${cartCount}`;
            var hdrCount = document.getElementById('count');
            var hdrCountM = document.getElementById('count-mobile');
            if (hdrCount) hdrCount.innerHTML = cartCount;
            if (hdrCountM) hdrCountM.innerHTML = cartCount;

            if (!carts || Object.keys(carts).length === 0) {
                document.getElementById('empty-cart-state').style.display = 'block';
                document.querySelector('.cart-main-area').style.display = 'none';
                if (typeof AllCarts === 'function') await AllCarts();
                return;
            }

            document.getElementById('empty-cart-state').style.display = 'none';
            document.querySelector('.cart-main-area').style.display = 'block';

            let productTotal = 0;

            Object.values(carts).forEach((cart) => {
                const q = parseInt(cart.quantity, 10) || 1;
                const unit = Number(cart.price) || 0;
                const line =
                    cart.subtotal != null && cart.subtotal !== ''
                        ? Number(cart.subtotal)
                        : unit * q;
                productTotal += line;
                const decDisabled = q <= 1 ? ' disabled' : '';
                const nameSafe = escapeHtml(cart.product_name);
                const imgSafe = escapeHtml(cart.image || '');
                tbodyEl.innerHTML += `
            <tr>
                <td class="product-thumbnail">
                    <a href="/product/detail/${cart.product_id}"><img class="img-responsive ml-15px" src="/images/products/thumbnail/${imgSafe}" alt="${nameSafe}" /></a>
                </td>
                <td class="product-name"><a href="/product/detail/${cart.product_id}">${nameSafe}</a></td>
                <td class="product-price-cart"><span class="amount">Rs. ${unit.toFixed(2)}</span></td>
                <td class="product-quantity">
                    <div class="cart-page-qty-stepper">
                        <button type="button" class="cart-page-qty-dec" title="Decrease quantity"${decDisabled}
                            onclick="cartPageQtyChange(${cart.product_id}, ${unit}, -1, this)">−</button>
                        <input type="number" class="cart-page-qty-input" name="quantity" min="1" value="${q}"
                            onchange="CartQty(${cart.product_id}, this.value, ${unit}, this)" />
                        <button type="button" class="cart-page-qty-inc" title="Increase quantity"
                            onclick="cartPageQtyChange(${cart.product_id}, ${unit}, 1, this)">+</button>
                    </div>
                </td>
                <td class="product-subtotal">Rs. ${line.toFixed(2)}</td>
                <td class="product-remove">
                    <button type="button" onclick="CartRemove(${cart.product_id}, this)">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>`;
            });

            pTotal.innerHTML = `Rs. ${productTotal.toFixed(2)}`;

            if (data.applied_coupon) {
                appliedCoupon = data.applied_coupon;
                document.getElementById('coupon_code').disabled = true;
                document.getElementById('coupon_code').value = data.applied_coupon.coupon_code;
                document.getElementById('couponbtn').style.pointerEvents = 'none';
                document.getElementById('couponbtn').style.opacity = '0.5';
                document.getElementById('removecoupon').style.display = 'block';

            }

            calculateGrandTotal(productTotal);

            standardShip.onchange = () => calculateGrandTotal(recalculateProductTotal());
            expressShip.onchange = () => calculateGrandTotal(recalculateProductTotal());
        };

        const ApplyCoupon = async () => {
            const couponCode = document.getElementById('coupon_code').value.trim();

            if (!couponCode) {
                document.getElementById('coupon_message').innerHTML = 'Please Enter Your Coupon Code';
                return
            }

            const response = await fetch(`{{ url('product/cart/apply-coupon') }}`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    coupon_code: couponCode
                })
            });

            const data = await response.json();

            if (data.status) {
                appliedCoupon = {
                    discount: data.discount
                };

                document.getElementById('coupon_code').disabled = true;
                document.getElementById('couponbtn').style.pointerEvents = 'none';
                document.getElementById('couponbtn').style.opacity = '0.5';

                const productTotal = parseFloat(
                    document.getElementById('producttotal').innerHTML.replace('Rs. ', '')
                );
                calculateGrandTotal(productTotal);
                document.getElementById('coupon_message').innerHTML = '';
                document.getElementById('removecoupon').style.display = 'block';


            } else {
                document.getElementById('coupon_message').innerHTML = data.message || 'Invalid or Expired Coupon';
            }
        };

        const RemoveCoupon = async () => {
            const response = await fetch(`{{ url('product/cart/remove-coupon') }}`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
            });

            const data = await response.json();

            if (data.status) {
                appliedCoupon = null;

                document.getElementById('coupon_code').disabled = false;
                document.getElementById('coupon_code').value = '';
                document.getElementById('couponbtn').style.pointerEvents = 'auto';
                document.getElementById('couponbtn').style.opacity = '1';
                document.getElementById('removecoupon').style.display = 'none';
                document.getElementById('coupon_message').innerHTML = '';

                // Recalculate without discount
                const productTotal = recalculateProductTotal();
                calculateGrandTotal(productTotal);
            }
        }

        const ClearCart = async () => {
            const response = await fetch(`{{ url('product/cart/clear') }}`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            let data = await response.json();
            if (!data.status) return;

            appliedCoupon = null;
            document.getElementById('empty-cart-state').style.display = 'block';
            document.querySelector('.cart-main-area').style.display = 'none';
            var hC = document.getElementById('count');
            var hCm = document.getElementById('count-mobile');
            if (hC) hC.innerHTML = '0';
            if (hCm) hCm.innerHTML = '0';
            if (typeof AllCarts === 'function') await AllCarts();
        };

        const CartQty = async (productId, qty, price, inputEl) => {
            const response = await fetch(`{{ url('product/cart/quantity') }}/${productId}`, {
                method: 'PUT',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    quantity: parseInt(qty, 10)
                })
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.status) {
                alert(data.message || 'Could not update quantity.');
                if (typeof data.max_qty === 'number') {
                    inputEl.value = data.max_qty;
                }
                await loadCart();
                return;
            }

            const row = inputEl.closest('tr');
            const unit = typeof data.unit_price === 'number' ? data.unit_price : parseFloat(price);
            const q = typeof data.quantity === 'number' ? data.quantity : parseInt(qty, 10);
            inputEl.value = q;
            row.querySelector('.product-price-cart .amount').innerHTML = `Rs. ${Number(unit).toFixed(2)}`;
            row.querySelector('.product-subtotal').innerHTML = `Rs. ${(unit * q).toFixed(2)}`;

            const decBtn = row.querySelector('.cart-page-qty-dec');
            if (decBtn) {
                decBtn.disabled = q <= 1;
            }

            const productTotal = recalculateProductTotal();
            document.getElementById('producttotal').innerHTML = `Rs. ${productTotal.toFixed(2)}`;
            calculateGrandTotal(productTotal);

            if (typeof AllCarts === 'function') {
                await AllCarts();
            }
        };

        const CartRemove = async (id, buttonEl) => {
            const response = await fetch(`{{ url('product/cart/remove') }}/${id}`, {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const data = await response.json().catch(() => ({}));

            if (data.status) {
                buttonEl.closest('tr').remove();

                const productTotal = recalculateProductTotal();
                document.getElementById('producttotal').innerHTML = `Rs. ${productTotal.toFixed(2)}`;
                document.getElementById('cartCount').innerHTML = `items ${data.cart_count}`;
                calculateGrandTotal(productTotal);

                var hc = document.getElementById('count');
                var hcm = document.getElementById('count-mobile');
                if (hc) hc.innerHTML = data.cart_count;
                if (hcm) hcm.innerHTML = data.cart_count;
                if (typeof AllCarts === 'function') await AllCarts();

                if (data.cart_count === 0) {
                    appliedCoupon = null;
                    document.getElementById('empty-cart-state').style.display = 'block';
                    document.querySelector('.cart-main-area').style.display = 'none';
                }
            } else {
                await loadCart();
            }
        };

        const SelectCity = async (provinceId) => {
            const cities = document.getElementById('allCities');
            const response = await fetch(`{{ url('product/cart/all/cities') }}/${provinceId}`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.status || !Array.isArray(data.cities)) {
                cities.innerHTML = '<option value="" disabled selected>Could not load cities</option>';
                return;
            }

            if (data.cities.length >= 1) {
                cities.innerHTML = '<option value="" disabled selected>Select a City</option>';
                data.cities.forEach(city => {
                    cities.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                });
            } else {
                cities.innerHTML = '<option value="" disabled selected>No City Available</option>';
            }
        };

        document.addEventListener('techmart:cart-changed', () => {
            if (document.getElementById('cartBody')) {
                loadCart();
            }
        });

        loadCart();
    </script>
@endsection
