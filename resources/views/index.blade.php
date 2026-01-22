@extends('layout')
@section('main')
    @include('slider')
    @include('product')

    @include('featured')

    @include('brand')
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
                                        <a class="d-inline-block" title="Facebook" target="_blank" rel="noopener noreferrer"
                                            href="#">
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-inline-block" title="Twitter" target="_blank" rel="noopener noreferrer"
                                            href="#">
                                            <i class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="d-inline-block" title="Tumblr" target="_blank" rel="noopener noreferrer"
                                            href="#">
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
                                        <strong>Email:</strong> <a href="mailto:demo@example.com">demo@example.com</a>
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
                                <img class="img-fluid" src="{{ asset('frontend/assets/images/icons/payment.png') }}"
                                    alt="payment-image" style="max-width: 250px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->

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
                                            src="{{ asset('frontend/assets/images/product-image/zoom-image/1.webp') }}"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-container gallery-thumbs mt-20px slider-nav-style-1 small-nav">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto"
                                            src="{{ asset('frontend/assets/images/product-image/small-image/1.webp') }}"
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
                                    <a href="#"><img src="{{ asset('frontend/assets/') }}images/icons/payment.png"
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
                            <img src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
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
@endsection
