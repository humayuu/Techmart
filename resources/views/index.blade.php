@extends('layout')
@section('main')
    @include('slider')
    @include('product')

    @include('featured')

    @include('brand')

    <!-- Modal -->
    <div class="modal modal-2 fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="pe-7s-close"></i>
                    </button>
                    <div class="row">
                        {{-- Image Col --}}
                        <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div id="quickViewImage" class="swiper-slide">
                                        {{-- JS fills this --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Product Details Col --}}
                        <div id="quickView" class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                            {{-- JS fills this --}}
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

    <script>
        let divEl = document.getElementById('quickView');
        let imgEl = document.getElementById('quickViewImage');

        const QuickView = async (id) => {
            const response = await fetch(`{{ url('/product/quick') }}/${id}`);

            if (!response.ok) return;

            const product = await response.json();
            let totalPrice = product.selling_price - product.discount_price;

            // Fill image
            imgEl.innerHTML = `
            <img
                class="img-responsive m-auto"
                src="{{ asset('images/products/') }}/${product.product_thumbnail}"
                alt="${product.product_name}"
            />`;

            // Fill product details
            divEl.innerHTML = `
            <div class="product-details-content quickview-content">
                <h2>${product.product_name}</h2>
                <div class="pricing-meta">
                    <ul class="d-flex">
                        <li class="new-price">Price: ${totalPrice}$</li>
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
                    <span class="read-review">
                        <a class="reviews" href="#">( 2 Review )</a>
                    </span>
                </div>
                <p class="mt-30px">${product.long_description}</p>
                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                    <span>Categories: </span>
                    <ul class="d-flex">
                        <li>
                            <a href="{{ url('/product/category') }}/${product.category.id}">
                                ${product.category.category_name}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                    <span>Brand: </span>
                    <ul class="d-flex">
                        <li>
                            <a href="{{ url('/product/brand') }}/${product.brand.id}">
                                ${product.brand.brand_name}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="pro-details-quality">
                    <div class="pro-details-cart">
                        <button class="add-cart">Add To Cart</button>
                    </div>
                    <div class="pro-details-compare-wishlist pro-details-wishlist">
                        <a href="#"><i class="pe-7s-like"></i></a>
                    </div>
                </div>
                <div class="payment-img">
                    <a href="#">
                        <img src="{{ asset('frontend/assets/images/icons/payment.png') }}" alt="" />
                    </a>
                </div>
            </div>`;
        }
    </script>
@endsection
