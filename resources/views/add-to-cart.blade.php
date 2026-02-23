    <!-- Modal Cart -->
    <div class="modal customize-class fade" id="exampleModal-Cart" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages">
                        <i class="pe-7s-check"></i> Added to cart successfully!
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                            <img id="img" src="" alt="Modern Smart Phone" />
                        </div>
                        <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const AddToCart = async (id) => {
            const img = document.getElementById('img');
            const countEl = document.getElementById('count');
            const countMobileEl = document.getElementById('count-mobile');
            try {
                const response = await fetch(`{{ url('product/add/to/cart') }}/${id}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const product = await response.json();
                img.src = `{{ asset('images/products') }}/${product.product_thumbnail}`;
                console.log('Success:', product);
                if (countEl) countEl.innerHTML = product.cart_count;
                if (countMobileEl) countMobileEl.innerHTML = product.cart_count;
            } catch (error) {
                console.error('Error:', error.message);
            }
        }
    </script>
