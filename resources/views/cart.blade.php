@extends('layout')
@section('main')
    <!-- Cart Area Start -->
    <div class="cart-main-area pt-100px pb-100px">
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
                                    <th>Until Price</th>
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
                    <form action="">
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
                                                    * Province
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
                                                    * City
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
                                                    * Shipping Zone
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
                                    <h5>Total products <span id="producttotal"></span></h5>
                                    <div class="total-shipping">
                                        <h5>Total shipping</h5>
                                        <ul>
                                            <li><input type="radio" id="standard" name="shipping" />
                                                Standard <span>Rs
                                                    200</span></li>
                                            <li><input type="radio" id="express" name="shipping" />
                                                Express <span>Rs.
                                                    300</span></li>
                                        </ul>
                                    </div>
                                    <h4 class="grand-totall-title">Grand Total <span id="grandtotal"></span></h4>
                                    <a href="checkout.html">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="text-center py-5 mt-5" style="display: none;">
        <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">Your cart is empty</h4>
        <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
        <a href="{{ url('/') }}">Start Shopping</a>
    </div>
    <!-- Cart Area End -->
@endsection
@section('scripts')
    <script>
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
            count.innerHTML = `items  ${cartCount}`;

            if (!carts || Object.keys(carts).length === 0) {
                document.querySelector('.text-center').style.display =
                    'block';
                document.querySelector('.cart-main-area').style.display =
                    'none';
                return;
            }
            let productTotal = 0;

            Object.values(carts).forEach((cart) => {
                productTotal += cart.price * cart.quantity

                tbodyEl.innerHTML += `  <tr>
                                        <td class="product-thumbnail">
                                            <a href=""><img class="img-responsive ml-15px" src="/images/products/${cart.image}"
                                                    alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">${cart.product_name}</a>
                                        </td>
                                        <td class="product-price-cart"><span class="amount">Rs. ${cart.price}</span>
                                        </td>
                                        <td class="product-quantity">
                                            <div>
                                                <input type="number" name="quantity" onchange="CartQty(${cart.product_id}, this.value, ${cart.price}, this)" value="${cart.quantity}" min="1"
                                                    style="width:75px; border:none" />
                                            </div>
                                        </td>
                                        <td class="product-subtotal" id="subTotal">Rs. ${cart.price * cart.quantity}</td>
                                        <td class="product-remove">
                                            <button onclick="CartRemove(${cart.product_id}, this)"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>`;
            });

            pTotal.innerHTML = `Rs.  ${productTotal}`;
            const calculateGrandTotal = (productTotal) => {
                let shipping = 0;

                if (standardShip.checked) {
                    shipping = 200;
                } else if (expressShip.checked) {
                    shipping = 300;
                }

                gTotal.innerHTML = `Rs. ${productTotal + shipping}`;
            };
            calculateGrandTotal(productTotal);


            standardShip.addEventListener('change', () => calculateGrandTotal(productTotal));
            expressShip.addEventListener('change', () => calculateGrandTotal(productTotal));

        }
        const ClearCart = async () => {
            const response = await fetch(`{{ url('product/cart/clear') }}`);
            let data = await response.json();
            if (!data.status) return;

            document.querySelector('.text-center').style.display =
                'block';
            document.querySelector('.cart-main-area').style.display =
                'none';

        }

        const CartQty = async (productId, qty, price, inputEl) => {
            const response = await fetch(`{{ url('product/cart/quantity') }}/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: qty
                })
            });

            const data = await response.json();

            if (data.status) {
                // Find the row of the changed input and update only subtotal
                const row = inputEl.closest('tr');
                const subtotalEl = row.querySelector('.product-subtotal');
                const newSubtotal = price * qty;
                subtotalEl.innerHTML = `Rs. ${newSubtotal}`;

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

                // Update grand total
                let shipping = 0;
                if (document.getElementById('standard').checked) shipping = 200;
                else if (document.getElementById('express').checked) shipping = 300;
                document.getElementById('grandtotal').innerHTML = `Rs. ${productTotal + shipping}`;
            }
        }

        // For Remove Cart
        const CartRemove = async (id, buttonEl) => {
            const response = await fetch(`{{ url('product/cart/remove') }}/${id}`);
            const data = await response.json();

            if (data.status) {
                // Remove only that row from DOM
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

                // Update totals
                document.getElementById('producttotal').innerHTML = `Rs. ${productTotal}`;
                document.getElementById('cartCount').innerHTML = `items ${data.cart_count}`;

                let shipping = 0;
                if (document.getElementById('standard').checked) shipping = 200;
                else if (document.getElementById('express').checked) shipping = 300;
                document.getElementById('grandtotal').innerHTML = `Rs. ${productTotal + shipping}`;

                // If cart is empty show empty state
                if (data.cart_count === 0) {
                    document.querySelector('.text-center').style.display = 'block';
                    document.querySelector('.cart-main-area').style.display = 'none';
                }
            }
        }



        loadCart();
    </script>
@endsection
