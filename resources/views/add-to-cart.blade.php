<!-- Modal Cart - Success -->
<div class="modal customize-class fade" id="exampleModal-Cart" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="modelbox">
        </div>
    </div>
</div>
<script>
    const AddToCart = async (id) => {
        const countEl = document.getElementById('count');
        const countMobileEl = document.getElementById('count-mobile');
        const divEl = document.getElementById('modelbox');
        try {
            const response = await fetch(`{{ url('product/add/to/cart') }}/${id}`);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const product = await response.json();

            if (product.quantity > 1) {
                divEl.innerHTML = `  <div class="modal-body text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
                <div class="tt-modal-messages" style="color: orange;">
                    <i class="pe-7s-info"></i> This product is already in your cart!
                </div>
                <div class="tt-modal-product">
                    <div class="tt-img">
                        <img id="img" src="" alt="Product Image" />
                    </div>
                    <h2 class="tt-title"><a href="#">Product Name</a></h2>
                </div>
                <div class="tt-modal-actions mt-3">
                    <p class="text-muted mb-3">Would you like to increase the quantity?</p>
                    <button type="button" class="me-2" id="btn-increase-qty">
                        <i class="pe-7s-plus"></i> Yes, Increase Quantity
                    </button>
                    <button type="button" class="" data-bs-dismiss="modal">
                        <i class="pe-7s-close"></i> No, Keep it
                        </button>
                </div>
            </div>`;


                const img = document.getElementById('img');
                const btnSuccess = document.getElementById('btn-increase-qty');
                img.src = `{{ asset('images/products/') }}/${product.product_thumbnail}`;
                console.log('Success:', product);
                if (countEl) countEl.innerHTML = product.cart_count;
                if (countMobileEl) countMobileEl.innerHTML = product.cart_count;

            } else {
                divEl.innerHTML = `  <div class="modal-body text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages">
                    <i class="pe-7s-check"></i> Added to cart successfully!
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                        <img id="img" src="" alt="Product Image" />
                        </div>
                        <h2 class="tt-title"><a href="#">Product Name</a></h2>
                        </div>
                        </div>`;
                const img = document.getElementById('img');
                img.src = `{{ asset('images/products/') }}/${product.product_thumbnail}`;
                console.log('Success:', product);
                if (countEl) countEl.innerHTML = product.cart_count;
                if (countMobileEl) countMobileEl.innerHTML = product.cart_count;

            }

        } catch (error) {
            console.error('Error:', error.message);
        }
    }
</script>
