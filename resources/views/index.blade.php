@extends('layout')
@section('main')
    <!-- Hero/Intro Slider Start -->
    <div class="section">
        <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1">
            <!-- Hero slider Active -->
            <div class="swiper-wrapper">
                @php
                    $sliders = \App\Models\Slider::where('status', 'active')->get();
                @endphp
                @foreach ($sliders as $slider)
                    <!-- Single slider item -->
                    <div class="hero-slide-item slider-height swiper-slide bg-color1"
                        data-bg-image="{{ asset('images/slider/' . $slider->slider_image) }}">
                        <div class="container h-100">
                            <div class="row h-100">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                    <div class="hero-slide-content slider-animated-1">
                                        <span class="category">Welcome To Techmart</span>
                                        <h2 class="title-1 text-dark">
                                            {{ $slider->title }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-white"></div>
            <!-- Add Arrows -->
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <!-- Hero/Intro Slider End -->
    <!-- Product Area Start -->
    <div class="product-area mt-5 pb-100px">
        <div class="container">
            <!-- Section Title & Tab Start -->
            <div class="row">
                <div class="col-12">
                    <!-- Tab Start -->
                    <div class="tab-slider d-md-flex justify-content-md-between align-items-md-center">
                        <ul class="product-tab-nav nav justify-content-start align-items-center">
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#newarrivals">
                                    New Arrivals
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#toprated">
                                    Top Rated
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#featured">
                                    Featured
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- Tab End -->
                </div>
            </div>
            <!-- Section Title & Tab End -->
            <div class="row">
                <div class="col">
                    <div class="tab-content mt-60px">
                        <!-- 1st tab start -->
                        <div class="tab-pane fade show active" id="newarrivals">
                            <div class="row mb-n-30px">
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Modern Smart Phone
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview" title="Quick view"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 1st tab end -->
                        <!-- 2nd tab start -->
                        <div class="tab-pane fade" id="toprated">
                            <div class="row">
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Modern Smart Phone
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-10%</span>
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/2.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/2.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Bluetooth Headphone
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$48.50</span>
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/3.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/3.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Music Box </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/4.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Air Pods 25Hjkl Black
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges"> </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/5.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/5.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Hand Watch </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-8%</span>
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/6.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/6.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Table Camera
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$138.50</span>
                                                <span class="new">$112.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/7.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Round Pocket Router
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-5%</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/8.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/8.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Power Bank 10000Mhp
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$260.00</span>
                                                <span class="new">$238.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 2nd tab end -->
                        <!-- 3rd tab start -->
                        <div class="tab-pane fade" id="featured">
                            <div class="row">
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Modern Smart Phone
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-10%</span>
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/2.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/2.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Bluetooth Headphone
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$48.50</span>
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/3.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/3.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Music Box </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">New</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/4.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Air Pods 25Hjkl Black
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges"> </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/5.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/5.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Hand Watch </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-8%</span>
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/6.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/6.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Smart Table Camera
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$138.50</span>
                                                <span class="new">$112.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="new">Sale</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/7.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Round Pocket Router
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="new">$38.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <!-- Single Prodect -->
                                    <div class="product">
                                        <span class="badges">
                                            <span class="sale">-5%</span>
                                        </span>
                                        <div class="thumb">
                                            <a href="single-product.html" class="image">
                                                <img src="{{ asset('frontend/assets/') }}images/product-image/8.webp"
                                                    alt="Product" />
                                                <img class="hover-image"
                                                    src="{{ asset('frontend/assets/') }}images/product-image/8.webp"
                                                    alt="Product" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <span class="category"><a href="#">Accessories</a></span>
                                            <h5 class="title">
                                                <a href="single-product.html">Power Bank 10000Mhp
                                                </a>
                                            </h5>
                                            <span class="price">
                                                <span class="old">$260.00</span>
                                                <span class="new">$238.50</span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Cart">
                                                <i class="pe-7s-shopbag"></i>
                                            </button>
                                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Wishlist">
                                                <i class="pe-7s-like"></i>
                                            </button>
                                            <button class="action quickview" data-link-action="quickview"
                                                title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="pe-7s-look"></i>
                                            </button>
                                            <button class="action compare" title="Compare" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal-Compare">
                                                <i class="pe-7s-refresh-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 3rd tab end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End -->
    <!-- Feature product area start -->
    <div class="feature-product-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Featured Offers</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 mb-md-35px mb-lm-35px">
                    <div class="single-feature-content">
                        <div class="feature-image">
                            <img src="{{ asset('frontend/assets/') }}images/feature-image/1.webp" alt="" />
                        </div>
                        <div class="top-content">
                            <h4 class="title">
                                <a href="single-product.html">Bluetooth Headphone </a>
                            </h4>
                            <span class="price">
                                <span class="old"><del>$48.50</del></span>
                                <span class="new">$38.50</span>
                            </span>
                        </div>
                        <div class="bottom-content">
                            <div class="deal-timing">
                                <div data-countdown="2023/09/15"></div>
                            </div>
                            <a href="single-product-variable.html" class="btn btn-primary m-auto">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="feature-right-content">
                        <div class="image-side">
                            <img src="{{ asset('frontend/assets/') }}images/feature-image/2.webp" alt="" />
                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-Cart">
                                <i class="pe-7s-shopbag"></i>
                            </button>
                        </div>
                        <div class="content-side">
                            <div class="deal-timing">
                                <span>End In:</span>
                                <div data-countdown="2024/09/15"></div>
                            </div>
                            <div class="prize-content">
                                <h5 class="title">
                                    <a href="single-product.html">Ladies Smart Watch</a>
                                </h5>
                                <span class="price">
                                    <span class="old">$48.50</span>
                                    <span class="new">$38.50</span>
                                </span>
                            </div>
                            <div class="product-feature">
                                <ul>
                                    <li>Predecessor : <span>None.</span></li>
                                    <li>Support Type : <span>Neutral.</span></li>
                                    <li>Cushioning : <span>High Energizing.</span></li>
                                    <li>Total Weight : <span> 300gm</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="feature-right-content mt-30px">
                        <div class="image-side">
                            <img src="{{ asset('frontend/assets/') }}images/feature-image/3.webp" alt="" />
                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-Cart">
                                <i class="pe-7s-shopbag"></i>
                            </button>
                        </div>
                        <div class="content-side">
                            <div class="deal-timing">
                                <span>End In:</span>
                                <div data-countdown="2023/09/15"></div>
                            </div>
                            <div class="prize-content">
                                <h5 class="title">
                                    <a href="single-product.html">Ladies Smart Watch</a>
                                </h5>
                                <span class="price">
                                    <span class="old">$48.50</span>
                                    <span class="new">$38.50</span>
                                </span>
                            </div>
                            <div class="product-feature">
                                <ul>
                                    <li>Predecessor : <span>None.</span></li>
                                    <li>Support Type : <span>Neutral.</span></li>
                                    <li>Cushioning : <span>High Energizing.</span></li>
                                    <li>Total Weight : <span> 300gm</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature product area End -->
    <!-- Brand area start -->
    <div class="brand-area pt-100px pb-100px">
        <div class="container">
            <div class="brand-slider swiper-container">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide brand-slider-item text-center">
                        <a href="#"><img class="img-fluid"
                                src="{{ asset('frontend/assets/') }}images/partner/1.png" alt="" /></a>
                    </div>
                    <div class="swiper-slide brand-slider-item text-center">
                        <a href="#"><img class="img-fluid"
                                src="{{ asset('frontend/assets/') }}images/partner/2.png" alt="" /></a>
                    </div>
                    <div class="swiper-slide brand-slider-item text-center">
                        <a href="#"><img class="img-fluid"
                                src="{{ asset('frontend/assets/') }}images/partner/3.png" alt="" /></a>
                    </div>
                    <div class="swiper-slide brand-slider-item text-center">
                        <a href="#"><img class="img-fluid"
                                src="{{ asset('frontend/assets/') }}images/partner/4.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand area end -->
    <!-- Footer Area Start -->
    <div class="footer-area">
        <div class="footer-container">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 mb-md-30px mb-lm-30px">
                            <div class="single-wedge">
                                <div class="footer-logo">
                                    <a href="index.html"><img
                                            src="{{ asset('frontend/assets/') }}images/logo/footer-logo.png"
                                            alt="" /></a>
                                </div>
                                <p class="about-text">
                                    Lorem ipsum dolor sit amet consl adipisi elit, sed do
                                    eiusmod templ incididunt ut labore
                                </p>
                                <ul class="link-follow">
                                    <li>
                                        <a class="m-0" title="Twitter" target="_blank" rel="noopener noreferrer"
                                            href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a title="Tumblr" target="_blank" rel="noopener noreferrer" href="#"><i
                                                class="fa fa-tumblr" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Facebook" target="_blank" rel="noopener noreferrer" href="#"><i
                                                class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Instagram" target="_blank" rel="noopener noreferrer" href="#"><i
                                                class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-60px">
                            <div class="single-wedge">
                                <h4 class="footer-herading">Services</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center">
                                            <li class="li">
                                                <a class="single-link" href="my-account.html">My Account</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="contact.html">Contact</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="cart.html">Shopping cart</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="shop-left-sidebar.html">Shop</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="login.html">Services Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-40px">
                            <div class="single-wedge">
                                <h4 class="footer-herading">My Account</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center">
                                            <li class="li">
                                                <a class="single-link" href="my-account.html">My Account</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="contact.html">Contact</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="cart.html">Shopping cart</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="shop-left-sidebar.html">Shop</a>
                                            </li>
                                            <li class="li">
                                                <a class="single-link" href="login.html">Services Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-12">
                            <div class="single-wedge">
                                <h4 class="footer-herading">Contact Info</h4>
                                <div class="footer-links">
                                    <!-- News letter area -->
                                    <p class="address">Address: Your Address Goes Here.</p>
                                    <p class="phone">
                                        Phone/Fax:<a href="tel:0123456789"> 0123456789</a>
                                    </p>
                                    <p class="mail">
                                        Email:<a href="mailto:demo@example.com">
                                            demo@example.com</a>
                                    </p>
                                    <p class="mail">
                                        <a href="https://demo@example.com"> demo@example.com</a>
                                    </p>
                                    <!-- News letter area  End -->
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="line-shape-top line-height-1">
                        <div class="row flex-md-row-reverse align-items-center">
                            <div class="col-md-6 text-center text-md-end">
                                <div class="payment-mth">
                                    <a href="#"><img class="img img-fluid"
                                            src="{{ asset('frontend/assets/') }}images/icons/payment.png"
                                            alt="payment-image" /></a>
                                </div>
                            </div>
                            <div class="col-md-6 text-center text-md-start">
                                <p class="copy-text">
                                    © 2022 <strong>Hmart</strong> Made With
                                    <i class="fa fa-heart" aria-hidden="true"></i> By
                                    <a class="company-name" href="https://themeforest.net/user/codecarnival/portfolio">
                                        <strong> Codecarnival </strong></a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->
    </div>

    <!-- Modal -->
    <div class="modal modal-2 fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                            <!-- Swiper -->
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/zoom-image/1.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/zoom-image/2.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/zoom-image/3.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/zoom-image/4.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/zoom-image/5.webp"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-container gallery-thumbs mt-20px slider-nav-style-1 small-nav">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/small-image/1.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/small-image/2.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/small-image/3.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/small-image/4.webp"
                                            alt="" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/') }}images/product-image/small-image/5.webp"
                                            alt="" />
                                    </div>
                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-buttons">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                            <div class="product-details-content quickview-content">
                                <h2>Modern Smart Phone</h2>
                                <div class="pricing-meta">
                                    <ul class="d-flex">
                                        <li class="new-price">$20.90</li>
                                    </ul>
                                </div>
                                <div class="pro-details-rating-wrap">
                                    <div class="rating-product">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <span class="read-review"><a class="reviews" href="#">( 2 Review
                                            )</a></span>
                                </div>
                                <p class="mt-30px">
                                    Lorem ipsum dolor sit amet, consecte adipisicing elit, sed
                                    do eiusmll tempor incididunt ut labore et dolore magna
                                    aliqua. Ut enim ad mill veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip exet commodo consequat. Duis
                                    aute irure dolor
                                </p>
                                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                                    <span>SKU:</span>
                                    <ul class="d-flex">
                                        <li>
                                            <a href="#">Ch-256xl</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                                    <span>Categories: </span>
                                    <ul class="d-flex">
                                        <li>
                                            <a href="#">Smart Device, </a>
                                        </li>
                                        <li>
                                            <a href="#">ETC</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                                    <span>Tags: </span>
                                    <ul class="d-flex">
                                        <li>
                                            <a href="#">Smart Device, </a>
                                        </li>
                                        <li>
                                            <a href="#">Phone</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton"
                                            value="1" />
                                    </div>
                                    <div class="pro-details-cart">
                                        <button class="add-cart">Add To Cart</button>
                                    </div>
                                    <div class="pro-details-compare-wishlist pro-details-wishlist">
                                        <a href="wishlist.html"><i class="pe-7s-like"></i></a>
                                    </div>
                                </div>
                                <div class="payment-img">
                                    <a href="#"><img
                                            src="{{ asset('frontend/assets/') }}images/icons/payment.png"
                                            alt="" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
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
                            <img src="{{ asset('frontend/assets/') }}images/product-image/1.webp"
                                alt="Modern Smart Phone" />
                        </div>
                        <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal wishlist -->
    <div class="modal customize-class fade" id="exampleModal-Wishlist" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages">
                        <i class="pe-7s-check"></i> Added to Wishlist successfully!
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                            <img src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                alt="Modern Smart Phone" />
                        </div>
                        <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal compare -->
    <div class="modal customize-class fade" id="exampleModal-Compare" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="tt-modal-messages">
                        <i class="pe-7s-check"></i> Added to compare successfully!
                    </div>
                    <div class="tt-modal-product">
                        <div class="tt-img">
                            <img src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                alt="Modern Smart Phone" />
                        </div>
                        <h2 class="tt-title"><a href="#">Modern Smart Phone</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
