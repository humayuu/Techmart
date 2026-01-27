@extends('layout')
@section('main')
    <div class="main-wrapper">
        <!-- Shop Page Start  -->
        <div class="shop-category-area pt-100px pb-100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="mb-5"><span class="text-secondary">Category:</span> <span
                                class="fw-bold">{{ $category->category_name }}</span>
                        </h1>
                        <!-- Shop Top Area Start -->
                        <div class="shop-top-bar d-flex">
                            <p class="compare-product"> <span>{{ $products->count() }}</span> Product Found of
                                <span>{{ $products->total() }}</span>
                            </p>
                            <!-- Left Side End -->
                            <div class="shop-tab nav">
                                <button class="active" data-bs-target="#shop-grid" data-bs-toggle="tab">
                                    <i class="fa fa-th" aria-hidden="true"></i>
                                </button>
                                <button data-bs-target="#shop-list" data-bs-toggle="tab">
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex align-items-center">
                                <div class="shot-product">
                                    <p>Sort By:</p>
                                </div>
                                <!-- Single Wedge End -->
                                <div class="header-bottom-set dropdown">
                                    <button class="dropdown-toggle header-action-btn" data-bs-toggle="dropdown">Default <i
                                            class="fa fa-angle-down"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a class="dropdown-item" href="#">Name, A to Z</a></li>
                                        <li><a class="dropdown-item" href="#">Name, Z to A</a></li>
                                        <li><a class="dropdown-item" href="#">Price, low to high</a></li>
                                        <li><a class="dropdown-item" href="#">Price, high to low</a></li>
                                        <li><a class="dropdown-item" href="#">Sort By new</a></li>
                                        <li><a class="dropdown-item" href="#">Sort By old</a></li>
                                    </ul>
                                </div>
                                <!-- Single Wedge Start -->
                            </div>
                            <!-- Right Side End -->
                        </div>
                        <!-- Shop Top Area End -->
                        <!-- Shop Bottom Area Start -->
                        <div class="shop-bottom-area">
                            <!-- Tab Content Area Start -->
                            <div class="row">
                                <div class="col">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="shop-grid">
                                            <div class="row mb-n-30px">
                                                @foreach ($products as $item)
                                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                                        <!-- Single Prodect -->
                                                        <div class="product">
                                                            <div class="thumb">
                                                                <a href="single-product.html" class="image">
                                                                    <img src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                                        alt="Product" />
                                                                    <img class="hover-image"
                                                                        src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                                        alt="Product" />
                                                                </a>
                                                            </div>
                                                            <div class="content">
                                                                <span class="category"><a
                                                                        href="#">{{ $item->category->category_name }}</a></span>
                                                                <h5 class="title"><a
                                                                        href="single-product.html">{{ $item->product_name }}
                                                                    </a>
                                                                </h5>
                                                                <span class="price">
                                                                    @if ($item->discount_price > 0)
                                                                        @php
                                                                            $finalPrice =
                                                                                $item->selling_price -
                                                                                $item->discount_price;
                                                                        @endphp
                                                                        <span
                                                                            class="old">${{ $item->selling_price }}</span>
                                                                        <span class="new">${{ $finalPrice }}</span>
                                                                    @else
                                                                        <span
                                                                            class="new">${{ $item->selling_price }}</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="actions">
                                                                <button title="Add To Cart" class="action add-to-cart"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal-Cart"><i
                                                                        class="pe-7s-shopbag"></i></button>
                                                                <button class="action wishlist" title="Wishlist"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal-Wishlist"><i
                                                                        class="pe-7s-like"></i></button>
                                                                <button class="action quickview"
                                                                    data-link-action="quickview" title="Quick view"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                                        class="pe-7s-look"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="tab-pane fade mb-n-30px" id="shop-list">
                                            <div class="shop-list-wrapper mb-30px">
                                                @foreach ($products as $tabProduct)
                                                    <div class="row">
                                                        <div class="col-md-5 col-lg-5 col-xl-4 mb-lm-30px">
                                                            <div class="product">
                                                                <div class="thumb">
                                                                    <a href="single-product.html" class="image">
                                                                        <img src="{{ asset('images/products/' . $tabProduct->product_thumbnail) }}"
                                                                            alt="Product" />
                                                                        <img class="hover-image"
                                                                            src="{{ asset('images/products/' . $tabProduct->product_thumbnail) }}"
                                                                            alt="Product" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7 col-xl-8">
                                                            <div class="content-desc-wrap">
                                                                <div class="content">
                                                                    <span class="category"><a
                                                                            href="#">{{ $tabProduct->category->category_name }}</a></span>
                                                                    <h5 class="title"><a
                                                                            href="single-product.html">{{ $tabProduct->product_name }}</a>
                                                                    </h5>
                                                                    <p>{{ $tabProduct->short_description }}</p>
                                                                </div>
                                                                <div class="box-inner">
                                                                    <span class="price">
                                                                        @if ($tabProduct->discount_price > 0)
                                                                            @php
                                                                                $finalPrice =
                                                                                    $tabProduct->selling_price -
                                                                                    $tabProduct->discount_price;
                                                                            @endphp
                                                                            <span
                                                                                class="old">${{ $tabProduct->selling_price }}</span>
                                                                            <span
                                                                                class="new">${{ $finalPrice }}</span>
                                                                        @else
                                                                            <span
                                                                                class="new">${{ $tabProduct->selling_price }}</span>
                                                                        @endif
                                                                    </span>
                                                                    <div class="actions">
                                                                        <button title="Add To Cart"
                                                                            class="action add-to-cart"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal-Cart"><i
                                                                                class="pe-7s-shopbag"></i></button>
                                                                        <button class="action wishlist" title="Wishlist"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal-Wishlist"><i
                                                                                class="pe-7s-like"></i></button>
                                                                        <button class="action quickview"
                                                                            data-link-action="quickview"
                                                                            title="Quick view" data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal"><i
                                                                                class="pe-7s-look"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Content Area End -->
                            <!--  Pagination Area Start -->
                            <div class="pro-pagination-style text-center text-lg-end" data-aos="fade-up"
                                data-aos-delay="200">
                                <div class="pages d-flex justify-content-end">
                                    {{ $products->links() }}
                                </div>
                            </div>
                            <!--  Pagination Area End -->
                        </div>
                        <!-- Shop Bottom Area End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Page End  -->
    </div>
@endsection
