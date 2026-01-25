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
                            $finalPrice = $product->selling_price - $product->discount_price;
                        @endphp
                        <div class="pricing-meta">
                            <span class="price mt-auto">
                                <span
                                    class="old text-muted text-decoration-line-through me-2">${{ $product->selling_price }}</span>
                                <span class="new fw-bold">${{ $finalPrice }}</span>
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
                        <p class="mt-30px">Lorem ipsum dolor sit amet, consecte adipisicing elit, sed do eiusmll
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mill veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip exet commodo consequat. Duis aute irure
                            dolor</p>
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
                                    <span class="text-dark">{{ Str::replaceFirst(' ', ',', $product->product_tags) }}</span>
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
                                        <li><span>Weight</span> 400 g</li>
                                        <li><span>Dimensions</span>10 x 10 x 15 cm</li>
                                        <li><span>Materials</span> 60% cotton, 40% polyester</li>
                                        <li><span>Other Info</span> American heirloom jean shorts pug seitan
                                            letterpress</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details1" class="tab-pane ">
                                <div class="product-description-wrapper">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius tempor
                                        incidid ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip efgx ea co consequat.
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                                        eu fugiat nulla pariatur. Excepteur sint occae cupidatat non proident, sunt
                                        in culpa qui
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
            <div class="row">
                <div class="col">
                    <div class="new-product-slider swiper-container slider-nav-style-1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <!-- Single Prodect -->
                                <div class="product">
                                    <span class="badges">
                                        <span class="new">New</span>
                                    </span>
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img src="assets/images/product-image/1.webp" alt="Product" />
                                            <img class="hover-image" src="assets/images/product-image/1.webp"
                                                alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <span class="category"><a href="#">Accessories</a></span>
                                        <h5 class="title"><a href="single-product.html">Modern Smart Phone
                                            </a>
                                        </h5>
                                        <span class="price">
                                            <span class="new">$38.50</span>
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Cart"><i class="pe-7s-shopbag"></i></button>
                                        <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Wishlist"><i class="pe-7s-like"></i></button>
                                        <button class="action quickview" data-link-action="quickview" title="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                class="pe-7s-look"></i></button>
                                        <button class="action compare" title="Compare" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Compare"><i
                                                class="pe-7s-refresh-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-buttons">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End -->
@endsection
