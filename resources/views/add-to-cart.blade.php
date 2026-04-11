@once
<style>
    /* Cart modal actions — match theme (.add-cart: #266bf9, radius 5px), not generic Bootstrap palette */
    .modal.customize-class .tt-modal-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0 20px;
    }
    .modal.customize-class .tt-modal-btn {
        border-radius: 5px;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 22px;
        line-height: 1.3;
        border: none;
        cursor: pointer;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }
    .modal.customize-class .tt-modal-btn-primary {
        background: #266bf9;
        color: #fff;
    }
    .modal.customize-class .tt-modal-btn-primary:hover {
        background: #000;
        color: #fff;
    }
    .modal.customize-class .tt-modal-btn-cancel {
        background: #fff;
        color: #333;
        border: 1px solid #e1e1e1;
    }
    .modal.customize-class .tt-modal-btn-cancel:hover {
        border-color: #266bf9;
        color: #266bf9;
    }
</style>
<!-- Modal Cart - Success -->
<div class="modal customize-class fade" id="exampleModal-Cart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modelbox">
        </div>
    </div>
</div>
<script>
    const showCartModal = () => {
        const el = document.getElementById('exampleModal-Cart');
        if (!el) return;
        const m = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
        m.show();
    };

    const showCartError = (message) => {
        const divEl = document.getElementById('modelbox');
        divEl.innerHTML = `<div class="modal-body text-center">
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
                <div class="tt-modal-messages" style="color: #c00;">
                    <i class="pe-7s-close-circle"></i> ${message}
                </div>
            </div>`;
        showCartModal();
    };

    const AddToCart = async (id, confirmIncrease = false) => {
        const countEl = document.getElementById('count');
        const countMobileEl = document.getElementById('count-mobile');
        const divEl = document.getElementById('modelbox');
        if (!divEl) {
            return;
        }
        const meta = document.querySelector('meta[name="csrf-token"]');
        const token = meta ? meta.getAttribute('content') : '';
        try {
            const response = await fetch(`{{ url('product/add/to/cart') }}/${id}`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ confirm: confirmIncrease }),
            });

            if (response.status === 419) {
                showCartError('Your session expired. Please refresh the page and try again.');
                return;
            }

            const product = await response.json().catch(() => ({}));

            if (!response.ok || product.status === false) {
                showCartError(product.message || 'Could not add this product to your cart.');
                return;
            }

            if (product.status === 'confirm' && product.already_in_cart) {
                const q = product.quantity ?? 1;
                divEl.innerHTML = `<div class="modal-body text-center">
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
                <div class="tt-modal-messages" style="color: #b45309;">
                    <i class="pe-7s-info"></i> This product is already in your cart
                </div>
                <p class="text-muted mb-2">Current quantity: <strong>${q}</strong></p>
                <div class="tt-modal-product">
                    <div class="tt-img">
                        <img id="img-confirm" alt="Product Image" />
                    </div>
                    <h2 class="tt-title"><a href="#">${product.product_name || 'Product'}</a></h2>
                </div>
                <div class="tt-modal-actions mt-3">
                    <p class="text-muted mb-3 w-100">Add one more to your cart?</p>
                    <button type="button" class="tt-modal-btn tt-modal-btn-primary" onclick="AddToCart(${id}, true)">
                        <i class="pe-7s-plus"></i> Yes, add one more
                    </button>
                    <button type="button" class="tt-modal-btn tt-modal-btn-cancel" data-dismiss="modal" data-bs-dismiss="modal">
                        <i class="pe-7s-close"></i> Cancel
                    </button>
                </div>
            </div>`;
                const imgC = document.getElementById('img-confirm');
                if (imgC && product.product_thumbnail) {
                    imgC.src = `{{ asset('images/products/thumbnail') }}/${product.product_thumbnail}`;
                }
                showCartModal();
                return;
            }

            const successMsg = product.incremented
                ? `<i class="pe-7s-check"></i> Quantity updated! You now have <strong>${product.quantity}</strong> in your cart.`
                : `<i class="pe-7s-check"></i> Added to cart successfully!`;

            divEl.innerHTML = `<div class="modal-body text-center">
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
                <div class="tt-modal-messages">${successMsg}</div>
                <div class="tt-modal-product">
                    <div class="tt-img">
                        <img id="img" alt="Product Image" />
                    </div>
                    <h2 class="tt-title"><a href="#">${product.product_name || 'Product'}</a></h2>
                </div>
            </div>`;
            const img = document.getElementById('img');
            if (img && product.product_thumbnail) {
                img.src = `{{ asset('images/products/thumbnail') }}/${product.product_thumbnail}`;
            }
            if (countEl) countEl.innerHTML = product.cart_count;
            if (countMobileEl) countMobileEl.innerHTML = product.cart_count;

            if (typeof AllCarts === 'function') {
                await AllCarts();
            }

            showCartModal();

        } catch (error) {
            console.error('Error:', error.message);
            showCartError('Something went wrong. Please try again.');
        }
    }
</script>
@endonce
