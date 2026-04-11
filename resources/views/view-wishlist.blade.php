{{-- Mini wishlist: public/frontend/assets/css/wishlist-offcanvas.css + js/wishlist-offcanvas.js --}}
<div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist"
    data-wishlist-url-all="{{ url('product/all/wishlist') }}"
    data-wishlist-url-remove="{{ url('product/wishlist/remove') }}"
    data-wishlist-thumb-base="{{ asset('images/products/thumbnail') }}">
    <div class="inner">
        <div class="head">
            <span class="title">Wishlist</span>
            <button type="button" class="offcanvas-close">×</button>
        </div>
        <div class="body customScroll">
            <ul class="minicart-product-list">
            </ul>
        </div>
        <div class="foot">
            <div class="buttons">
                <a href="{{ route('wishlist') }}" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
            </div>
        </div>
    </div>
</div>
