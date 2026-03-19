<!-- Modal wishlist -->
<div class="modal customize-class fade" id="exampleModal-Wishlist" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wishlist-modal-content">
            {{-- Content injected by JS --}}
        </div>
    </div>
</div>

<script>
    const AddToWishlist = async (id) => {
        const divEl = document.getElementById('wishlist-modal-content');

        try {
            const response = await fetch(`{{ url('product/add/to/wishlist') }}/${id}`);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const product = await response.json();

            const isAdded = product.status === 'added';

            divEl.innerHTML = `
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages ${isAdded ? '' : 'text-warning'}">
                        <i class="${isAdded ? 'pe-7s-check' : 'pe-7s-info'}"></i>
                        ${isAdded ? 'Added to Wishlist successfully!' : 'This item is already in your Wishlist.'}
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                            <img src="${product.image}" alt="${product.product_name}" />
                        </div>
                        <h2 class="tt-title"><a href="#">${product.product_name}</a></h2>
                    </div>
                </div>`;

            const modal = new bootstrap.Modal(document.getElementById('exampleModal-Wishlist'));
            modal.show();

        } catch (error) {
            console.error('Error:', error.message);
        }
    }
</script>
