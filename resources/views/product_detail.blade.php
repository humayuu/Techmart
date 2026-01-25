@extends('layout')
@section('main')
    <!-- breadcrumb-area end -->
    <!-- Product Details Area Start -->
    <div class="product-details-area pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                    <!-- Swiper -->
                    <div class="swiper-container zoom-top">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="img-responsive m-auto"
                                    src="{{ asset('images/products/' . $product->product_thumbnail) }}" alt="">
                                <a class="venobox full-preview" data-gall="myGallery"
                                    href="{{ asset('images/products/' . $product->product_thumbnail) }}">
                                    <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @php
                        $images = json_decode($product->product_multiple_image);
                    @endphp
                    <div class="swiper-container mt-20px zoom-thumbs slider-nav-style-1 small-nav">
                        <div class="swiper-wrapper">
                            @foreach ($images as $img)
                                <div class="swiper-slide">
                                    <img class="img-responsive m-auto" src="{{ asset('images/products/' . $img) }}"
                                        alt="">

                                </div>
                            @endforeach
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-buttons">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-details-content quickview-content ml-25px">
                        <h2>{{ $product->product_name }}</h2>
                        @php
                            $sellingPrice = $product->selling_price ?? 0;
                            $discountPrice = $product->discount_price ?? 0;
                            $finalPrice = max(0, $sellingPrice - $discountPrice);
                            $hasDiscount = $discountPrice > 0 && $finalPrice < $sellingPrice;
                        @endphp

                        <div class="pricing-meta">
                            <span class="price mt-auto d-flex flex-column gap-1">
                                @if ($hasDiscount)
                                    <span class="old text-muted text-decoration-line-through fs-5">
                                        ${{ number_format($sellingPrice, 2) }}
                                    </span>
                                @endif
                                <span class="new fw-bold text-danger fs-2">
                                    ${{ number_format($finalPrice, 2) }}
                                </span>
                            </span>
                        </div>
                        <div class="pro-details-rating-wrap">
                            <div class="rating-product">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <span class="read-review"><a class="reviews" href="#">(5 Customer
                                    Review)</a></span>
                        </div>
                        <p class="mt-30px">{{ $product->short_description }}</p>
                        <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                            <span>Product Code:</span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#">{{ $product->product_code }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                            <span>Category: </span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#">{{ $product->category->category_name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                            <span>Brand: </span>
                            <ul class="d-flex">
                                <li>
                                    <a href="#">{{ $product->brand->brand_name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                            <span>Tags: </span>
                            <ul class="d-flex">
                                <li>
                                    <span
                                        class="text-dark">{{ Str::replaceFirst(' ', ',', $product->product_tags) }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-details-quality">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1" />
                            </div>
                            <div class="pro-details-cart">
                                <button class="add-cart"> Add To
                                    Cart</button>
                            </div>
                            <div class="pro-details-compare-wishlist pro-details-wishlist ">
                                <a href="wishlist.html"><i class="pe-7s-like"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- product details description area start -->
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <button class="active" data-bs-toggle="tab" data-bs-target="#des-details2">Information</button>
                            <button data-bs-toggle="tab" data-bs-target="#des-details1">Description</button>
                            <button data-bs-toggle="tab" data-bs-target="#des-details3">Reviews (02)</button>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details2" class="tab-pane active">
                                <div class="product-anotherinfo-wrapper text-start">
                                    <ul>
                                        <li><span>Weight</span> {{ $product->product_weight }} g</li>
                                        <li><span>Other Info</span> {{ strip_tags($product->other_info) }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details1" class="tab-pane ">
                                <div class="product-description-wrapper">
                                    <p>
                                        {{ strip_tags($product->long_description) }}
                                    </p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="review-wrapper">
                                            <div class="single-review">
                                                <div class="review-img">
                                                    <img src="assets/images/review-image/1.png" alt="" />
                                                </div>
                                                <div class="review-content">
                                                    <div class="review-top-wrap">
                                                        <div class="review-left">
                                                            <div class="review-name">
                                                                <h4>White Lewis</h4>
                                                            </div>
                                                            <div class="rating-product">
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <div class="review-left">
                                                            <a href="#">Reply</a>
                                                        </div>
                                                    </div>
                                                    <div class="review-bottom">
                                                        <p>
                                                            Vestibulum ante ipsum primis aucibus orci luctustrices
                                                            posuere
                                                            cubilia Curae Suspendisse viverra ed viverra. Mauris
                                                            ullarper
                                                            euismod vehicula. Phasellus quam nisi, congue id nulla.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="single-review child-review">
                                                <div class="review-img">
                                                    <img src="assets/images/review-image/2.png" alt="" />
                                                </div>
                                                <div class="review-content">
                                                    <div class="review-top-wrap">
                                                        <div class="review-left">
                                                            <div class="review-name">
                                                                <h4>White Lewis</h4>
                                                            </div>
                                                            <div class="rating-product">
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <div class="review-left">
                                                            <a href="#">Reply</a>
                                                        </div>
                                                    </div>
                                                    <div class="review-bottom">
                                                        <p>Vestibulum ante ipsum primis aucibus orci luctustrices
                                                            posuere
                                                            cubilia Curae Sus pen disse viverra ed viverra. Mauris
                                                            ullarper
                                                            euismod vehicula.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="ratting-form-wrapper pl-50">
                                            <h3>Add a Review</h3>
                                            <div class="ratting-form">
                                                <form action="#">
                                                    <div class="star-box">
                                                        <span>Your rating:</span>
                                                        <div class="rating-product">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="rating-form-style">
                                                                <input placeholder="Name" type="text" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="rating-form-style">
                                                                <input placeholder="Email" type="email" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="rating-form-style form-submit">
                                                                <textarea name="Your Review" placeholder="Message"></textarea>
                                                                <button class="btn btn-primary btn-hover-color-primary "
                                                                    type="submit" value="Submit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details description area end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area Start -->
    <div class="product-area related-product">
        <div class="container">
            <!-- Section Title & Tab Start -->
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center m-0">
                        <h2 class="title">Related Products</h2>
                        <p>There are many variations of passages of Lorem Ipsum available</p>
                    </div>
                </div>
            </div>
            <!-- Section Title & Tab End -->

            @if ($relatedProducts->count() > 3)
                <div class="row">
                    <div class="col">
                        <div class="new-product-slider swiper-container slider-nav-style-1">
                            <div class="swiper-wrapper">
                                @foreach ($relatedProducts as $item)
                                    <div class="swiper-slide">
                                        <!-- Single Product -->
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="{{ route('product.detail', $item->id) }}" class="image">
                                                    <img src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                        alt="Product" />
                                                    <img class="hover-image"
                                                        src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <span class="category">
                                                    <a href="#">{{ $item->category->category_name }}</a>
                                                </span>
                                                <h5 class="title">
                                                    <a href="{{ route('product.detail', $item->id) }}">
                                                        {{ $item->product_name }}
                                                    </a>
                                                </h5>
                                                @php
                                                    $sellingPrice = $item->selling_price ?? 0;
                                                    $discountPrice = $item->discount_price ?? 0;
                                                    $finalPrice = max(0, $sellingPrice - $discountPrice);
                                                    $hasDiscount = $discountPrice > 0 && $finalPrice < $sellingPrice;
                                                @endphp
                                                <span class="price">
                                                    @if ($hasDiscount)
                                                        <span class="old text-muted text-decoration-line-through me-2">
                                                            ${{ number_format($sellingPrice, 2) }}
                                                        </span>
                                                    @endif
                                                    <span class="new fw-bold text-danger">
                                                        ${{ number_format($finalPrice, 2) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="actions">
                                                <button title="Add To Cart" class="action add-to-cart"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
                                                    <i class="pe-7s-shopbag"></i>
                                                </button>
                                                <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal-Wishlist">
                                                    <i class="pe-7s-like"></i>
                                                </button>
                                                <button class="action quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="pe-7s-look"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-buttons">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5" role="alert">
                            <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                            <h5>No Related Products Available</h5>
                            <p class="mb-0">Check back soon for our latest offers!</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Product Area End -->

@endsection
