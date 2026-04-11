<!-- Modal wishlist -->
<div class="modal customize-class fade" id="exampleModal-Wishlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="wishlist-modal-content">
            {{-- Content injected by JS --}}
        </div>
    </div>
</div>

<script>
    const wishlistThumbBase = @json(asset('images/products/thumbnail'));

    const AddToWishlist = async (id) => {
        const divEl = document.getElementById('wishlist-modal-content');
        const modalEl = document.getElementById('exampleModal-Wishlist');
        if (!divEl || !modalEl) {
            return;
        }

        const countEl = document.getElementById('wishlist-count');
        const countMobileEl = document.getElementById('wishlist-count-mobile');

        try {
            const response = await fetch(`{{ url('product/add/to/wishlist') }}/${id}`, {
                headers: {
                    'Accept': 'application/json',
                },
            });

            const product = await response.json().catch(() => ({}));

            if (!response.ok || product.status === 'error') {
                divEl.innerHTML = `
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages text-danger">
                        <i class="pe-7s-close-circle"></i>
                        ${product.message || 'Could not add this product to your wishlist.'}
                    </div>
                </div>`;
                var errModal = bootstrap.Modal.getInstance(modalEl);
                if (!errModal) {
                    errModal = new bootstrap.Modal(modalEl);
                }
                errModal.show();
                return;
            }

            const isAdded = product.status === 'added';
            const isDuplicate = product.status === 'already_in_wishlist';
            const thumb = product.image ? `${wishlistThumbBase}/${product.image}` : '';

            divEl.innerHTML = `
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages ${isAdded ? '' : 'text-warning'}">
                        <i class="${isAdded ? 'pe-7s-check' : 'pe-7s-info'}"></i>
                        ${isAdded ? 'Added to Wishlist successfully!' : (isDuplicate ? 'This item is already in your Wishlist.' : 'Wishlist updated.')}
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                            <img src="${thumb}" alt="${product.product_name || ''}" />
                        </div>
                        <h2 class="tt-title"><a href="#">${product.product_name || ''}</a></h2>
                    </div>
                </div>`;

            if (typeof product.wishlist_count === 'number') {
                if (countEl) countEl.innerHTML = product.wishlist_count;
                if (countMobileEl) countMobileEl.innerHTML = product.wishlist_count;
            }

            var wishModal = bootstrap.Modal.getInstance(modalEl);
            if (!wishModal) {
                wishModal = new bootstrap.Modal(modalEl);
            }
            wishModal.show();

            if (typeof AllWishlist === 'function') {
                await AllWishlist();
            }

        } catch (error) {
            console.error('AddToWishlist:', error.message);
            divEl.innerHTML = `
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages text-danger">
                        <i class="pe-7s-close-circle"></i>
                        Something went wrong. Please try again.
                    </div>
                </div>`;
            var failModal = bootstrap.Modal.getInstance(modalEl);
            if (!failModal) {
                failModal = new bootstrap.Modal(modalEl);
            }
            failModal.show();
        }
    };
</script>
