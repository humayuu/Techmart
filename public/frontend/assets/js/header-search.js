/**
 * Header live search: debounce, abort in-flight requests, a11y, Escape to close.
 */
(function () {
    'use strict';

    var boot = document.getElementById('tm-header-search-boot');
    if (!boot || !boot.dataset) {
        return;
    }

    var SEARCH_API = boot.dataset.searchApi || '';
    var SEARCH_RESULTS = boot.dataset.searchResults || '';
    var PLACEHOLDER_IMG = boot.dataset.placeholderImg || '';

    if (!SEARCH_API || !SEARCH_RESULTS) {
        return;
    }

    function escapeHtml(text) {
        if (text == null) {
            return '';
        }
        var d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }

    function formatRs(n) {
        var x = Number(n);
        if (Number.isNaN(x)) {
            return '0.00';
        }
        return x.toLocaleString('en-PK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    }

    function initSearch(inputId, dropdownId) {
        var input = document.getElementById(inputId);
        var dropdown = document.getElementById(dropdownId);
        var form = input && input.closest('form');
        if (!input || !dropdown || !form) {
            return;
        }

        var timer;
        var abortController;

        function setDropdownOpen(open) {
            dropdown.classList.toggle('is-open', open);
            if (!open) {
                dropdown.innerHTML = '';
            }
            input.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        input.setAttribute('aria-expanded', 'false');
        input.setAttribute('aria-controls', dropdownId);
        input.setAttribute('aria-autocomplete', 'list');
        if (!input.getAttribute('autocomplete')) {
            input.setAttribute('autocomplete', 'off');
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            var q = String(input.value).trim();

            if (abortController) {
                abortController.abort();
                abortController = null;
            }

            if (q.length < 2) {
                setDropdownOpen(false);
                return;
            }

            timer = setTimeout(function () {
                if (abortController) {
                    abortController.abort();
                }
                abortController = new AbortController();

                var url = SEARCH_API + '?q=' + encodeURIComponent(q);
                fetch(url, {
                    signal: abortController.signal,
                    credentials: 'same-origin',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(function (res) {
                        if (!res.ok) {
                            throw new Error('bad status');
                        }
                        return res.json();
                    })
                    .then(function (products) {
                        if (!products.length) {
                            dropdown.innerHTML =
                                '<div class="tm-header-search__empty">No results found</div>';
                            setDropdownOpen(true);
                            return;
                        }

                        var items = products
                            .map(function (p) {
                                var name = escapeHtml(p.name);
                                var href = String(p.url || '#');
                                var img = String(p.image || PLACEHOLDER_IMG);
                                var price = formatRs(p.price);
                                return (
                                    '<a class="tm-header-search__item" href="' +
                                    href +
                                    '">' +
                                    '<img class="tm-header-search__item-img" src="' +
                                    img +
                                    '" alt="" width="44" height="44" loading="lazy" ' +
                                    'onerror="this.onerror=null;this.src=' +
                                    JSON.stringify(PLACEHOLDER_IMG) +
                                    '">' +
                                    '<div class="tm-header-search__item-text">' +
                                    '<div class="tm-header-search__item-name">' +
                                    name +
                                    '</div>' +
                                    '<div class="tm-header-search__item-price">Rs. ' +
                                    price +
                                    '</div></div></a>'
                                );
                            })
                            .join('');

                        var footer =
                            '<div class="tm-header-search__footer">' +
                            '<a href="' +
                            SEARCH_RESULTS +
                            '?q=' +
                            encodeURIComponent(q) +
                            '">View all results</a></div>';

                        dropdown.innerHTML = items + footer;
                        setDropdownOpen(true);
                    })
                    .catch(function (err) {
                        if (err && err.name === 'AbortError') {
                            return;
                        }
                        dropdown.innerHTML =
                            '<div class="tm-header-search__error">Search is temporarily unavailable. Try again.</div>';
                        setDropdownOpen(true);
                    });
            }, 280);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                setDropdownOpen(false);
                input.blur();
            }
        });

        document.addEventListener(
            'pointerdown',
            function (e) {
                if (!form.contains(e.target)) {
                    setDropdownOpen(false);
                }
            },
            true
        );

        form.addEventListener('submit', function () {
            setDropdownOpen(false);
        });
    }

    function run() {
        initSearch('live-search-desktop', 'search-dropdown-desktop');
        initSearch('live-search-mobile', 'search-dropdown-mobile');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
