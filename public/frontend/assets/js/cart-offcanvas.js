/**
 * Mini cart: thumbnail, name, qty, unit + line price, remove.
 */
(function () {
    'use strict';

    var panel = document.getElementById('offcanvas-cart');
    if (!panel) {
        return;
    }

    var urlAll = panel.getAttribute('data-cart-url-all');
    var urlRemoveBase = panel.getAttribute('data-cart-url-remove');

    if (!urlAll || !urlRemoveBase) {
        console.warn('cart-offcanvas: missing data attributes on #offcanvas-cart');
        return;
    }

    function escHtml(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function formatRs(n) {
        var x = Number(n);
        if (isNaN(x)) {
            x = 0;
        }
        return x.toFixed(2);
    }

    async function allCarts() {
        try {
            var response = await fetch(urlAll, {
                headers: { Accept: 'application/json' },
                credentials: 'same-origin',
            });
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            var data = await response.json();
            var cartList = document.querySelector('#offcanvas-cart .minicart-product-list');
            if (!cartList) {
                return;
            }
            cartList.innerHTML = '';

            if (!data.status || !data.carts || Object.keys(data.carts).length === 0) {
                cartList.innerHTML = '<li class="text-center">Your cart is empty.</li>';
                return;
            }

            var thumbBase = panel.getAttribute('data-cart-thumb-base') || '';
            Object.values(data.carts).forEach(function (cart) {
                var qty = parseInt(cart.quantity, 10) || 1;
                var unit = Number(cart.price);
                if (isNaN(unit)) {
                    unit = 0;
                }
                var lineTotal =
                    cart.subtotal != null && cart.subtotal !== ''
                        ? Number(cart.subtotal)
                        : unit * qty;
                if (isNaN(lineTotal)) {
                    lineTotal = unit * qty;
                }

                var pid = cart.product_id;
                var nameSafe = escHtml(cart.product_name);
                var imgSrc = thumbBase ? thumbBase + '/' + escHtml(cart.image) : '';

                cartList.innerHTML +=
                    '<li>' +
                    '<a href="/product/detail/' +
                    pid +
                    '" class="image">' +
                    '<img src="' +
                    imgSrc +
                    '" alt="' +
                    nameSafe +
                    '" />' +
                    '</a>' +
                    '<div class="content">' +
                    '<a href="/product/detail/' +
                    pid +
                    '" class="title">' +
                    nameSafe +
                    '</a>' +
                    '<div class="minicart-meta">' +
                    '<span class="minicart-line-total">Rs. ' +
                    formatRs(lineTotal) +
                    '</span>' +
                    '<span class="minicart-qty-unit">Qty: ' +
                    qty +
                    ' × Rs. ' +
                    formatRs(unit) +
                    ' each</span>' +
                    '</div>' +
                    '<button type="button" class="remove cart-remove-btn" data-cart-remove="' +
                    pid +
                    '" title="Remove from cart">×</button>' +
                    '</div>' +
                    '</li>';
            });
        } catch (e) {
            console.error('Cart fetch error:', e.message);
        }
    }

    async function removeFromMiniCart(id) {
        try {
            var meta = document.querySelector('meta[name="csrf-token"]');
            var token = meta ? meta.getAttribute('content') : '';
            var response = await fetch(urlRemoveBase + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });
            var data = await response.json().catch(function () {
                return {};
            });
            if (!response.ok || !data.status) {
                await allCarts();
                return;
            }
            await allCarts();
            var countEl = document.getElementById('count');
            var countMobileEl = document.getElementById('count-mobile');
            var n = typeof data.cart_count === 'number' ? data.cart_count : 0;
            if (countEl) {
                countEl.innerHTML = n;
            }
            if (countMobileEl) {
                countMobileEl.innerHTML = n;
            }
            document.dispatchEvent(new CustomEvent('techmart:cart-changed', { detail: { source: 'minicart-remove' } }));
        } catch (e) {
            console.error('Remove mini cart error:', e.message);
            await allCarts();
        }
    }

    panel.addEventListener('click', function (e) {
        var rm = e.target.closest('[data-cart-remove]');
        if (rm && panel.contains(rm)) {
            e.preventDefault();
            var rid = rm.getAttribute('data-cart-remove');
            if (rid) {
                removeFromMiniCart(parseInt(rid, 10));
            }
        }
    });

    window.AllCarts = allCarts;
    window.RemoveFromMiniCart = removeFromMiniCart;

    document.addEventListener('DOMContentLoaded', function () {
        allCarts();
    });
})();
