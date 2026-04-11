{{-- Mini cart: public/frontend/assets/css/cart-offcanvas.css + js/cart-offcanvas.js --}}
<div id="offcanvas-cart" class="offcanvas offcanvas-cart"
    data-cart-url-all="{{ url('product/all/carts') }}"
    data-cart-url-remove="{{ url('product/cart/remove') }}"
    data-cart-thumb-base="{{ asset('images/products/thumbnail') }}">
    <div class="inner">
        <div class="head">
            <span class="title">Cart</span>
            <button type="button" class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
            </ul>
        </div>
        <div class="foot">
            <div class="buttons mt-30px">
                <a href="{{ route('cart') }}" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
            </div>
        </div>
    </div>
</div>
