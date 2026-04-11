/**
 * Category rail: 5 per page; smooth fade when moving forward/backward.
 */
(function () {
    'use strict';

    var PAGE_SIZE = 5;
    var FADE_MS = 220;

    function init() {
        var list = document.getElementById('tmCatRailList');
        var vp = document.getElementById('tmCatRailViewport');
        var prev = document.getElementById('tmCatRailPrev');
        var next = document.getElementById('tmCatRailNext');
        if (!list || !vp || !prev || !next) {
            return;
        }

        var animating = false;
        var currentPage = 0;

        function categoryItems() {
            return Array.prototype.slice.call(
                list.querySelectorAll('.tm-category-rail__item:not(.tm-category-rail__item--empty)')
            );
        }

        function totalPages() {
            var n = categoryItems().length;
            return n === 0 ? 0 : Math.ceil(n / PAGE_SIZE);
        }

        function updateVisibility() {
            var items = categoryItems();
            var pages = totalPages();

            if (pages === 0) {
                return;
            }

            if (currentPage >= pages) {
                currentPage = Math.max(0, pages - 1);
            }

            var start = currentPage * PAGE_SIZE;
            items.forEach(function (li, index) {
                if (index >= start && index < start + PAGE_SIZE) {
                    li.classList.remove('is-hidden');
                } else {
                    li.classList.add('is-hidden');
                }
            });
        }

        function updateButtons() {
            var pages = totalPages();
            if (pages === 0) {
                prev.disabled = true;
                next.disabled = true;
                return;
            }
            prev.disabled = currentPage <= 0;
            next.disabled = currentPage >= pages - 1;
        }

        function renderInstant() {
            updateVisibility();
            updateButtons();
        }

        function renderSmooth(goDelta) {
            var pages = totalPages();
            if (pages === 0 || animating) {
                return;
            }

            var nextPage = currentPage + goDelta;
            if (nextPage < 0 || nextPage > pages - 1) {
                return;
            }

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                currentPage = nextPage;
                renderInstant();
                return;
            }

            animating = true;
            prev.disabled = true;
            next.disabled = true;
            vp.classList.add('is-fading');

            window.setTimeout(function () {
                currentPage = nextPage;
                updateVisibility();
                updateButtons();

                window.requestAnimationFrame(function () {
                    window.requestAnimationFrame(function () {
                        vp.classList.remove('is-fading');
                        animating = false;
                        updateButtons();
                    });
                });
            }, FADE_MS);
        }

        prev.addEventListener('click', function () {
            if (currentPage > 0) {
                renderSmooth(-1);
            }
        });

        next.addEventListener('click', function () {
            var pages = totalPages();
            if (currentPage < pages - 1) {
                renderSmooth(1);
            }
        });

        window.addEventListener('resize', function () {
            window.requestAnimationFrame(renderInstant);
        });

        renderInstant();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
