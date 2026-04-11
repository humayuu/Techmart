@php
    $seo = App\Models\SeoSetting::find(1);
@endphp
<!doctype html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechMart</title>
    <meta name="description" content="{{ $seo->meta_description }}" />
    <meta name="keywords" content="{{ $seo->meta_keyword }}">
    <meta name="author" content="{{ $seo->meta_author }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/images/favicon.ico') }}" />
    <!-- CSS ============================================ -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/venobox.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.min.css') }}" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/wishlist-offcanvas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/cart-offcanvas.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/cart-page.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/product-cards.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/header-categories-rail.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/header-search.css') }}" />
    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="main-wrapper">
        <header>
            @php
                $categories = \App\Models\Category::orderBy('category_name')->get();
            @endphp
            <!-- Header top area start -->
            <div class="header-top">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="welcome-text">
                                <p>Free Shipping with Easy Returns</p>
                            </div>
                        </div>
                        <div class="col d-none d-lg-block">
                            <div class="top-nav">
                                <ul>
                                    <li>
                                        <a href="{{ route('contact.us') }}"><i class="fa fa-envelope"></i> Contact
                                            us</a>
                                    </li>
                                    @if (Auth::check())
                                        <li>
                                            <a href="{{ route('profile.edit') }}"><i class="fa fa-user"></i> My
                                                Account</a>
                                        </li>
                                    @endif
                                    @if (!Auth::check())
                                        <li>
                                            <a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Sign In Or
                                                Register</a>
                                        </li>
                                    @endif



                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Header top area end -->
            <!-- Header action area start -->
            @php
                $setting = \App\Models\Setting::findOrFail(1);
            @endphp
            <div class="header-bottom d-none d-lg-block">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-3 col">
                            <div class="header-logo">
                                <a href="{{ url('/') }}" class="text-decoration-none fw-bold display-5">
                                    {{ $setting->company_name }}
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="search-element">
                                <form class="tm-header-search" action="{{ route('search.results') }}" method="get"
                                    role="search" autocomplete="off">
                                    <div class="tm-header-search__inner">
                                        <label class="visually-hidden" for="live-search-desktop">Search products</label>
                                        <input type="search" id="live-search-desktop" name="q"
                                            class="tm-header-search__input" placeholder="Search products…"
                                            value="{{ request('q') }}" maxlength="120" autocomplete="off"
                                            enterkeyhint="search">
                                        <div id="search-dropdown-desktop" class="tm-header-search__dropdown"
                                            role="listbox" aria-label="Search suggestions"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col">
                            <div class="header-actions">
                                <!-- Single Wedge Start -->
                                <!-- Desktop wishlist count -->
                                <a onclick="AllWishlist()" href="#offcanvas-wishlist"
                                    class="header-action-btn offcanvas-toggle">
                                    <i class="pe-7s-like"></i>
                                    <span class="header-action-num" id="wishlist-count">
                                        {{ count(session('wishlist', [])) }}
                                    </span>
                                </a>
                                <!-- Single Wedge End -->
                                <a onclick="AllCarts()" href="#offcanvas-cart"
                                    class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num" id="count">
                                        {{ count(session('cart', [])) }}
                                    </span>
                                </a>
                                <a href="#offcanvas-mobile-menu"
                                    class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                                    <i class="pe-7s-menu"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header action area end -->
            <!-- Header action area start -->
            <div class="header-bottom d-lg-none sticky-nav style-1">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-3 col">
                            <div class="header-logo">
                                <a href="{{ url('/') }}" class="text-decoration-none fw-bold display-5">
                                    {{ $setting->company_name }}
                                </a>
                            </div>
                        </div>
                        <div class="mobile-search-box col-12 d-lg-none order-3 mt-2 pt-1">
                            <div class="search-element max-width-100">
                                <form class="tm-header-search" action="{{ route('search.results') }}" method="get"
                                    role="search" autocomplete="off">
                                    <div class="tm-header-search__inner">
                                        <label class="visually-hidden" for="live-search-mobile">Search products</label>
                                        <input type="search" id="live-search-mobile" name="q"
                                            class="tm-header-search__input" placeholder="Search products…"
                                            value="{{ request('q') }}" maxlength="120" autocomplete="off"
                                            enterkeyhint="search">
                                        <div id="search-dropdown-mobile" class="tm-header-search__dropdown"
                                            role="listbox" aria-label="Search suggestions"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col">
                            <div class="header-actions">
                                <!-- Mobile wishlist count -->
                                <a onclick="AllWishlist()" href="#offcanvas-wishlist"
                                    class="header-action-btn offcanvas-toggle">
                                    <i class="pe-7s-like"></i>
                                    <span class="header-action-num" id="wishlist-count-mobile">
                                        {{ count(session('wishlist', [])) }}
                                    </span>
                                </a>
                                <!-- Single Wedge End -->
                                <a onclick="AllCarts()" href="#offcanvas-cart"
                                    class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num" id="count-mobile">
                                        {{ count(session('cart', [])) }}
                                    </span>
                                </a>
                                <a href="#offcanvas-mobile-menu"
                                    class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                                    <i class="pe-7s-menu"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header action area end -->
            <!-- header navigation area start — single-row category rail + scroll buttons -->
            <div class="header-nav-area d-none d-lg-block sticky-nav">
                <div class="container">
                    <nav class="tm-category-rail" aria-label="Product categories">
                        <button type="button" class="tm-category-rail__btn tm-category-rail__btn--prev"
                            id="tmCatRailPrev" title="Backward — previous categories"
                            aria-label="Backward, previous categories">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            <span class="visually-hidden">Backward</span>
                        </button>
                        <div class="tm-category-rail__viewport" id="tmCatRailViewport">
                            <ul class="tm-category-rail__list" id="tmCatRailList" aria-live="polite">
                                @forelse ($categories as $category)
                                    <li class="tm-category-rail__item">
                                        <a class="tm-category-rail__link"
                                            href="{{ route('category.wise.product', $category->id) }}">{{ $category->category_name }}</a>
                                    </li>
                                @empty
                                    <li class="tm-category-rail__item tm-category-rail__item--empty">
                                        <span class="text-danger small">No categories</span>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <button type="button" class="tm-category-rail__btn tm-category-rail__btn--next"
                            id="tmCatRailNext" title="Forward — next categories"
                            aria-label="Forward, next categories">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            <span class="visually-hidden">Forward</span>
                        </button>
                    </nav>
                </div>
            </div>
            <!-- header navigation area end -->
        </header>
        <!-- offcanvas overlay start -->
        <div class="offcanvas-overlay"></div>
        <!-- offcanvas overlay end -->

        @include('view-wishlist')
        @include('add-to-wishlist')

        @include('view_cart')
        @include('add-to-cart')

        <!-- OffCanvas Menu Start -->
        <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
            <button class="offcanvas-close"></button>
            <div class="user-panel">
                <ul>
                    <li>
                        <a href="{{ route('contact.us') }}"><i class="fa fa-envelope"></i> Contact us</a>
                    </li>
                    <li>
                        <a href="my-account.html"><i class="fa fa-user"></i> My Account</a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Sign In</a>
                    </li>


                </ul>
            </div>
            <div class="inner customScroll">
                <div class="offcanvas-menu mb-4">
                    <p class="text-white-50 small text-uppercase mb-2">Categories</p>
                    <ul class="list-unstyled mb-0">
                        @forelse ($categories as $category)
                            <li class="mb-1">
                                <a href="{{ route('category.wise.product', $category->id) }}">{{ $category->category_name }}</a>
                            </li>
                        @empty
                            <li><span class="text-danger">No categories</span></li>
                        @endforelse
                    </ul>
                </div>
                <!-- OffCanvas Menu End -->
                <div class="offcanvas-social mt-auto">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-google"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- OffCanvas Menu End -->


        @yield('main')
        <!-- Footer Area Start -->
        <div class="footer-area">
            <div class="footer-container">
                <div class="footer-top">
                    <div class="container">
                        <div class="row justify-content-center">
                            <!-- About Section -->
                            <div class="col-md-6 col-lg-5 mb-4 mb-lg-0 text-center">
                                <div class="single-wedge">
                                    <h4 class="footer-herading mb-3">About {{ $setting->company_name }}</h4>
                                    <p>
                                        {{ $setting->description }}
                                    </p>
                                    <ul class="link-follow list-unstyled d-flex justify-content-center gap-3 mb-0">
                                        <li>
                                            <a class="d-inline-block" title="Facebook" target="_blank"
                                                rel="noopener noreferrer" href="{{ $setting->facebook }}">
                                                <i class="fa-brands fa-facebook-f"></i> </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Twitter" target="_blank"
                                                rel="noopener noreferrer" href="{{ $setting->x }}">
                                                <i class="fa-brands fa-x-twitter"></i> </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Linkedin" target="_blank"
                                                rel="noopener noreferrer" href="{{ $setting->linkedin }}">
                                                <i class="fa-brands fa-linkedin"></i> </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Youtube" target="_blank"
                                                rel="noopener noreferrer" href="{{ $setting->youtube }}">
                                                <i class="fa-brands fa-youtube"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Contact Info Section -->
                            <div class="col-md-6 col-lg-5 text-center">
                                <div class="single-wedge">
                                    <h4 class="footer-herading mb-3">Contact Info</h4>
                                    <div class="footer-links">
                                        <p class="address mb-2">
                                            <i class="fa fa-map-marker me-2"></i>
                                            <strong>Address:</strong> {{ $setting->company_address }}
                                        </p>
                                        <p class="phone mb-2">
                                            <i class="fa fa-phone me-2"></i>
                                            <strong>Phone:</strong> <a href="tel:0123456789">{{ $setting->phone }}</a>
                                        </p>
                                        <p class="mail mb-2">
                                            <i class="fa fa-envelope me-2"></i>
                                            <strong>Email:</strong> <a
                                                href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row align-items-center py-3">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                <p class="copy-text mb-0">
                                    © {{ now()->format('Y') }}
                                    <strong>{{ $setting->company_name }}</strong>. All
                                    Rights
                                    Reserved.
                                </p>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="payment-mth">
                                    <img class="img-fluid"
                                        src="{{ asset('frontend/assets/images/icons/payment.png') }}"
                                        alt="payment-image" style="max-width: 250px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area End -->

        <!-- Global Vendor, plugins JS -->
        <!-- JS Files ============================================ -->
        <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/scrollUp.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/venobox.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins/mailchimp-ajax.js') }}"></script>
        <!--Main JS (Common Activation Codes)-->
        <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/wishlist-offcanvas.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/cart-offcanvas.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/header-categories-rail.js') }}"></script>
        <script>
            (function() {
                const SEARCH_API = @json(route('search'));
                const SEARCH_RESULTS = @json(route('search.results'));
                const PLACEHOLDER_IMG = @json(asset('frontend/assets/images/product-image/1.webp'));

                function escapeHtml(text) {
                    if (text == null) return '';
                    const d = document.createElement('div');
                    d.textContent = text;
                    return d.innerHTML;
                }

                function formatRs(n) {
                    const x = Number(n);
                    if (Number.isNaN(x)) return '0.00';
                    return x.toLocaleString('en-PK', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                function setDropdownOpen(dropdown, open) {
                    dropdown.classList.toggle('is-open', open);
                    if (!open) dropdown.innerHTML = '';
                }

                function initSearch(inputId, dropdownId) {
                    const input = document.getElementById(inputId);
                    const dropdown = document.getElementById(dropdownId);
                    const form = input && input.closest('form');
                    if (!input || !dropdown || !form) return;

                    let timer;

                    input.addEventListener('input', function() {
                        clearTimeout(timer);
                        const q = this.value.trim();

                        if (q.length < 2) {
                            setDropdownOpen(dropdown, false);
                            return;
                        }

                        timer = setTimeout(function() {
                            const url = SEARCH_API + '?q=' + encodeURIComponent(q);
                            fetch(url, {
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(function(res) {
                                    if (!res.ok) throw new Error('bad status');
                                    return res.json();
                                })
                                .then(function(products) {
                                    if (!products.length) {
                                        dropdown.innerHTML =
                                            '<div class="tm-header-search__empty">No results found</div>';
                                        setDropdownOpen(dropdown, true);
                                        return;
                                    }

                                    const items = products.map(function(p) {
                                        const name = escapeHtml(p.name);
                                        const href = String(p.url || '#');
                                        const img = String(p.image || PLACEHOLDER_IMG);
                                        const price = formatRs(p.price);
                                        return '<a class="tm-header-search__item" href="' + href + '">' +
                                            '<img class="tm-header-search__item-img" src="' + img +
                                            '" alt="" width="44" height="44" loading="lazy" ' +
                                            'onerror="this.onerror=null;this.src=' + JSON.stringify(PLACEHOLDER_IMG) +
                                            '">' +
                                            '<div class="tm-header-search__item-text">' +
                                            '<div class="tm-header-search__item-name">' + name + '</div>' +
                                            '<div class="tm-header-search__item-price">Rs. ' + price +
                                            '</div></div></a>';
                                    }).join('');

                                    const footer = '<div class="tm-header-search__footer">' +
                                        '<a href="' + SEARCH_RESULTS + '?q=' + encodeURIComponent(q) +
                                        '">View all results</a></div>';

                                    dropdown.innerHTML = items + footer;
                                    setDropdownOpen(dropdown, true);
                                })
                                .catch(function() {
                                    dropdown.innerHTML =
                                        '<div class="tm-header-search__error">Search is temporarily unavailable. Try again.</div>';
                                    setDropdownOpen(dropdown, true);
                                });
                        }, 280);
                    });

                    document.addEventListener('click', function(e) {
                        if (!form.contains(e.target)) setDropdownOpen(dropdown, false);
                    });

                    form.addEventListener('submit', function() {
                        setDropdownOpen(dropdown, false);
                    });
                }

                initSearch('live-search-desktop', 'search-dropdown-desktop');
                initSearch('live-search-mobile', 'search-dropdown-mobile');
            })();
        </script>
        @yield('scripts')
</body>

</html>
