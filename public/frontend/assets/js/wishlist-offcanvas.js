/**
 * Offcanvas + full-page wishlist. No full page reload on remove.
 * Requires #offcanvas-wishlist with data-wishlist-url-all, data-wishlist-url-remove, data-wishlist-thumb-base.
 */
(function () {
    'use strict';

    var panel = document.getElementById('offcanvas-wishlist');
    if (!panel) {
        return;
    }

    var urlAll = panel.getAttribute('data-wishlist-url-all');
    var urlRemoveBase = panel.getAttribute('data-wishlist-url-remove');
    var thumbBase = panel.getAttribute('data-wishlist-thumb-base');

    if (!urlAll || !urlRemoveBase || !thumbBase) {
        console.warn('wishlist-offcanvas: missing data attributes on #offcanvas-wishlist');
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

    function syncWishlistPageTable(removedProductId) {
        var tbody = document.getElementById('wishlist-page-tbody');
        if (!tbody) {
            return;
        }
        var row = tbody.querySelector(
            'tr[data-wishlist-row][data-product-id="' + removedProductId + '"]'
        );
        if (row) {
            row.remove();
        }
        var remaining = tbody.querySelectorAll('tr[data-wishlist-row]');
        if (remaining.length === 0) {
            var existingEmpty = tbody.querySelector('tr.wishlist-empty-placeholder');
            if (existingEmpty) {
                existingEmpty.style.display = '';
            } else {
                tbody.innerHTML =
                    '<tr class="wishlist-empty-placeholder">' +
                    '<td colspan="7" class="text-center text-danger p-4">Your wishlist is empty.</td></tr>';
            }
        }
    }

    async function allWishlist() {
        try {
            var response = await fetch(urlAll, {
                headers: { Accept: 'application/json' },
                credentials: 'same-origin',
            });
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            var data = await response.json();
            var wishlistEl = document.querySelector('#offcanvas-wishlist .minicart-product-list');
            if (!wishlistEl) {
                return;
            }
            wishlistEl.innerHTML = '';
            if (!data.status || !data.wishlist || Object.keys(data.wishlist).length === 0) {
                wishlistEl.innerHTML = '<li class="text-center">Your wishlist is empty.</li>';
                return;
            }
            Object.values(data.wishlist).forEach(function (item) {
                var pid = item.product_id;
                var nameSafe = escHtml(item.product_name);
                var catSafe = escHtml(String(item.category_name || '').trim());
                var brandSafe = escHtml(String(item.brand_name || '').trim());
                var metaHtml =
                    '<div class="wishlist-mini-meta">' +
                    '<span class="wishlist-mini-price">Rs. ' +
                    formatRs(item.price) +
                    '</span>';
                if (catSafe) {
                    metaHtml += '<span class="wishlist-mini-line">Category: ' + catSafe + '</span>';
                }
                if (brandSafe) {
                    metaHtml += '<span class="wishlist-mini-line">Brand: ' + brandSafe + '</span>';
                }
                metaHtml += '</div>';
                wishlistEl.innerHTML +=
                    '<li>' +
                    '<a href="/product/detail/' +
                    pid +
                    '" class="image">' +
                    '<img src="' +
                    thumbBase +
                    '/' +
                    escHtml(item.image) +
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
                    metaHtml +
                    '<button type="button" class="remove wishlist-remove-btn" data-wishlist-remove="' +
                    pid +
                    '" title="Remove from wishlist">×</button>' +
                    '</div>' +
                    '</li>';
            });
        } catch (e) {
            console.error('Wishlist fetch error:', e.message);
        }
    }

    async function removeFromWishlist(id) {
        try {
            var meta = document.querySelector('meta[name="csrf-token"]');
            var token = meta ? meta.getAttribute('content') : '';
            var response = await fetch(urlRemoveBase + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
            });
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            var data = await response.json();
            if (data.status) {
                await allWishlist();
                var countEl = document.getElementById('wishlist-count');
                var countMobileEl = document.getElementById('wishlist-count-mobile');
                var n = typeof data.wishlist_count === 'number' ? data.wishlist_count : 0;
                if (countEl) {
                    countEl.innerHTML = n;
                }
                if (countMobileEl) {
                    countMobileEl.innerHTML = n;
                }
                syncWishlistPageTable(id);
            }
        } catch (e) {
            console.error('Remove wishlist error:', e.message);
        }
    }

    function onWishlistPanelClick(e) {
        var rmBtn = e.target.closest('[data-wishlist-remove]');
        if (rmBtn && panel.contains(rmBtn)) {
            e.preventDefault();
            var rid = rmBtn.getAttribute('data-wishlist-remove');
            if (rid) {
                removeFromWishlist(parseInt(rid, 10));
            }
        }
    }

    panel.addEventListener('click', onWishlistPanelClick);

    document.addEventListener('click', function (e) {
        var pageRm = e.target.closest('[data-wishlist-page-remove]');
        if (!pageRm) {
            return;
        }
        e.preventDefault();
        var rid = pageRm.getAttribute('data-wishlist-page-remove');
        if (rid) {
            removeFromWishlist(parseInt(rid, 10));
        }
    });

    window.syncWishlistPageTable = syncWishlistPageTable;
    window.AllWishlist = allWishlist;
    window.RemoveFromWishlist = removeFromWishlist;

    document.addEventListener('DOMContentLoaded', function () {
        allWishlist();
    });

    panel.addEventListener('shown.bs.offcanvas', function () {
        allWishlist();
    });
})();

