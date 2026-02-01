<!doctype html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechMart</title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="TechMart-Smart Product eCommerce html Template" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/images/favicon.ico') }}" />
    <!-- CSS ============================================ -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font.awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/pe-icon-7-stroke.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/venobox.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.min.css') }}" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
</head>

<body>
    <div class="main-wrapper">
        <header>
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
                                        <a href="my-account.html"><i class="fa fa-envelope"></i> Contact us</a>
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
            <div class="header-bottom d-none d-lg-block">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-3 col">
                            <div class="header-logo">
                                <a href="{{ url('/') }}" class="text-decoration-none fw-bold display-5">
                                    Tech<span class="fw-normal">Mart</span>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="search-element">
                                <form action="#">
                                    <input type="text" placeholder="Search" />
                                    <button><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col">
                            <div class="header-actions">
                                <!-- Single Wedge Start -->
                                <a href="#offcanvas-wishlist" class="header-action-btn offcanvas-toggle">
                                    <i class="pe-7s-like"></i>
                                </a>
                                <!-- Single Wedge End -->
                                <a href="#offcanvas-cart"
                                    class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">01</span>
                                    <!-- <span class="cart-amount">€30.00</span> -->
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
                                    Tech<span class="fw-normal">Mart</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="search-element">
                                <form action="#">
                                    <input type="text" placeholder="Search" />
                                    <button><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-3 col">
                            <div class="header-actions">
                                <!-- Single Wedge Start -->
                                <a href="#offcanvas-wishlist" class="header-action-btn offcanvas-toggle">
                                    <i class="pe-7s-like"></i>
                                </a>
                                <!-- Single Wedge End -->
                                <a href="#offcanvas-cart"
                                    class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">01</span>
                                    <!-- <span class="cart-amount">€30.00</span> -->
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
            <!-- header navigation area start -->
            <div class="header-nav-area d-none d-lg-block sticky-nav">
                <div class="container">
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    <div class="header-nav">
                        <div class="main-menu position-relative">
                            <ul>
                                @forelse ($categories as $category)
                                    <li><a
                                            href="{{ route('category.wise.product', $category->id) }}">{{ $category->category_name }}</a>
                                    </li>
                                @empty
                                    <span class="text-center text-danger">No Category Found!</span>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header navigation area end -->
            <div class="mobile-search-box d-lg-none">
                <div class="container">
                    <!-- mobile search start -->
                    <div class="search-element max-width-100">
                        <form action="#">
                            <input type="text" placeholder="Search" />
                            <button><i class="pe-7s-search"></i></button>
                        </form>
                    </div>
                    <!-- mobile search start -->
                </div>
            </div>
        </header>
        <!-- offcanvas overlay start -->
        <div class="offcanvas-overlay"></div>
        <!-- offcanvas overlay end -->
        <!-- OffCanvas Wishlist Start -->
        <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
            <div class="inner">
                <div class="head">
                    <span class="title">Wishlist</span>
                    <button class="offcanvas-close">×</button>
                </div>
                <div class="body customScroll">
                    <ul class="minicart-product-list">
                        <li>
                            <a href="single-product.html" class="image"><img
                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                    alt="Cart product Image" /></a>
                            <div class="content">
                                <a href="single-product.html" class="title">Modern Smart Phone</a>
                                <span class="quantity-price">1 x <span class="amount">$21.86</span></span>
                                <a href="#" class="remove">×</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="foot">
                    <div class="buttons">
                        <a href="wishlist.html" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- OffCanvas Wishlist End -->


        <!-- OffCanvas Cart Start -->
        <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
            <div class="inner">
                <div class="head">
                    <span class="title">Cart</span>
                    <button class="offcanvas-close">×</button>
                </div>
                <div class="body customScroll">
                    <ul class="minicart-product-list">
                        <li>
                            <a href="single-product.html" class="image"><img
                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                    alt="Cart product Image" /></a>
                            <div class="content">
                                <a href="single-product.html" class="title">Modern Smart Phone</a>
                                <span class="quantity-price">1 x <span class="amount">$18.86</span></span>
                                <a href="#" class="remove">×</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="foot">
                    <div class="buttons mt-30px">
                        <a href="cart.html" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
                        <a href="checkout.html" class="btn btn-outline-dark current-btn">checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- OffCanvas Cart End -->

        <!-- OffCanvas Menu Start -->
        <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
            <button class="offcanvas-close"></button>
            <div class="user-panel">
                <ul>
                    <li>
                        <a href="my-account.html"><i class="fa fa-envelope"></i> Contact us</a>
                    </li>
                    <li>
                        <a href="my-account.html"><i class="fa fa-user"></i> My Account</a>
                    </li>

                    <li>
                        <a href="login.html"><i class="fa fa-sign-in"></i> Sign In</a>
                    </li>


                </ul>
            </div>
            <div class="inner customScroll">
                <div class="offcanvas-menu mb-4">
                    <ul>
                        <li>
                            <ul>
                                <ul>
                                    @forelse ($categories as $category)
                                        <li><a
                                                href="{{ route('category.wise.product', $category->id) }}">{{ $category->category_name }}</a>
                                        </li>
                                    @empty
                                        <span class="text-center text-danger">No Category Found!</span>
                                    @endforelse
                                </ul>
                            </ul>
                        </li>
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
                                    <h4 class="footer-herading mb-3">About TechMart</h4>
                                    <p>
                                        Lorem ipsum dolor sit amet consl adipisi elit, sed do
                                        eiusmod templ incididunt ut labore
                                    </p>
                                    <ul class="link-follow list-unstyled d-flex justify-content-center gap-3 mb-0">
                                        <li>
                                            <a class="d-inline-block" title="Facebook" target="_blank"
                                                rel="noopener noreferrer" href="#">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Twitter" target="_blank"
                                                rel="noopener noreferrer" href="#">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Tumblr" target="_blank"
                                                rel="noopener noreferrer" href="#">
                                                <i class="fa fa-tumblr" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="d-inline-block" title="Instagram" target="_blank"
                                                rel="noopener noreferrer" href="#">
                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                            </a>
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
                                            <strong>Address:</strong> Your Address Goes Here
                                        </p>
                                        <p class="phone mb-2">
                                            <i class="fa fa-phone me-2"></i>
                                            <strong>Phone:</strong> <a href="tel:0123456789">0123456789</a>
                                        </p>
                                        <p class="mail mb-2">
                                            <i class="fa fa-envelope me-2"></i>
                                            <strong>Email:</strong> <a
                                                href="mailto:demo@example.com">demo@example.com</a>
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
                                    © 2026 <strong>TechMart</strong>. All Rights Reserved.
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
</body>

</html>
