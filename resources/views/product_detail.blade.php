@extends('layout')
@section('main')
    <div class="product-details-area pt-100px pb-100px">
        <div class="container">
            <nav class="pdp-breadcrumb mb-4" aria-label="Breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('category.wise.product', $product->category_id) }}"
                                class="text-decoration-none">{{ $product->category->category_name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-truncate" style="max-width: 12rem;" aria-current="page"
                        title="{{ $product->product_name }}">{{ Str::limit($product->product_name, 42) }}</li>
                </ol>
            </nav>

            @php
                $sellingPrice = (float) ($product->selling_price ?? 0);
                $discountPrice = (float) ($product->discount_price ?? 0);
                $finalPrice = max(0, $sellingPrice - $discountPrice);
                $hasDiscount = $discountPrice > 0 && $finalPrice < $sellingPrice;
                $qtyAvailable = max(0, (int) ($product->product_qty ?? 0));
                $isActive = ($product->status ?? '') === 'active';
                $canPurchase = $isActive && $qtyAvailable > 0;

                $rawGallery = $product->product_multiple_image;
                if (is_array($rawGallery)) {
                    $images = $rawGallery;
                } elseif (is_string($rawGallery) && $rawGallery !== '') {
                    $decoded = json_decode($rawGallery, true);
                    $images = is_array($decoded) ? $decoded : [];
                } else {
                    $images = [];
                }
                $pdpExtraCount = count(array_filter($images));
                $mainThumbUrl = asset('images/products/thumbnail/' . $product->product_thumbnail);
            @endphp

            <div class="row g-4 g-xl-5 align-items-start">
                <div class="col-lg-6">
                    <div class="pdp-gallery">
                        {{-- Main + additional slides must match thumbs 1:1 so Swiper thumbs + clicks work --}}
                        <div class="swiper-container zoom-top">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="pdp-main-img img-responsive"
                                        src="{{ $mainThumbUrl }}"
                                        alt="{{ $product->product_name }}">
                                    <a class="venobox full-preview" data-gall="myGallery"
                                        href="{{ $mainThumbUrl }}">
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                    </a>
                                </div>
                                @foreach ($images as $img)
                                    @if (! empty($img))
                                        @php
                                            $slideUrl = asset('images/products/additional_images/' . $img);
                                        @endphp
                                        <div class="swiper-slide">
                                            <img class="pdp-main-img img-responsive" src="{{ $slideUrl }}"
                                                alt="{{ $product->product_name }} — gallery">
                                            <a class="venobox full-preview" data-gall="myGallery"
                                                href="{{ $slideUrl }}">
                                                <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @if ($pdpExtraCount > 0)
                            <div class="swiper-container mt-20px zoom-thumbs slider-nav-style-1 small-nav">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img class="img-responsive m-auto" src="{{ $mainThumbUrl }}"
                                            alt="{{ $product->product_name }} — thumbnail">
                                    </div>
                                    @foreach ($images as $img)
                                        @if (! empty($img))
                                            <div class="swiper-slide">
                                                <img class="img-responsive m-auto"
                                                    src="{{ asset('images/products/additional_images/' . $img) }}"
                                                    alt="{{ $product->product_name }} — gallery">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="swiper-buttons">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="pdp-summary product-details-content quickview-content ps-lg-4">
                        <h1 class="pdp-title h2 mb-3">{{ $product->product_name }}</h1>

                        <div class="pdp-price-block pricing-meta mb-3 pb-3 border-bottom">
                            <span class="price mt-auto d-flex flex-column flex-sm-row flex-wrap align-items-baseline gap-2 gap-sm-3">
                                @if ($hasDiscount)
                                    <span class="old text-muted text-decoration-line-through fs-5 mb-0">
                                        Rs. {{ number_format($sellingPrice, 2) }}
                                    </span>
                                @endif
                                <span class="new fw-bold text-danger fs-2 mb-0">
                                    Rs. {{ number_format($finalPrice, 2) }}
                                </span>
                            </span>
                        </div>

                        @if ($canPurchase)
                            <p class="pdp-stock pdp-stock--in text-success small fw-semibold mb-3 mb-md-4 d-flex align-items-center gap-2">
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                <span>In stock</span>
                            </p>
                        @elseif ($isActive)
                            <p class="pdp-stock pdp-stock--out text-warning small fw-semibold mb-3 mb-md-4 d-flex align-items-center gap-2">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span>Out of stock</span>
                            </p>
                        @else
                            <p class="pdp-stock pdp-stock--na text-muted small fw-semibold mb-3 mb-md-4 d-flex align-items-center gap-2">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                <span>This product is not available</span>
                            </p>
                        @endif

                        @if ($product->short_description)
                            <p class="pdp-lead text-muted mb-4">{{ $product->short_description }}</p>
                        @endif

                        <dl class="product-meta-list pdp-meta-list small mb-0">
                            @if ($product->category)
                                <div class="d-flex flex-wrap gap-2 py-2 border-bottom">
                                    <dt class="mb-0 text-muted">Category</dt>
                                    <dd class="mb-0 ms-auto text-end">
                                        <a href="{{ route('category.wise.product', $product->category_id) }}"
                                            class="text-decoration-none">
                                            {{ $product->category->category_name }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if ($product->brand)
                                <div class="d-flex flex-wrap gap-2 py-2 border-bottom">
                                    <dt class="mb-0 text-muted">Brand</dt>
                                    <dd class="mb-0 ms-auto text-end">
                                        <a href="{{ route('brand.wise.product', $product->brand_id) }}"
                                            class="text-decoration-none">
                                            {{ $product->brand->brand_name }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            <div class="d-flex flex-wrap gap-2 py-2">
                                <dt class="mb-0 text-muted">Tags</dt>
                                <dd class="mb-0 ms-auto text-end text-dark">
                                    {{ $product->product_tags ? Str::replaceFirst(' ', ',', $product->product_tags) : '—' }}
                                </dd>
                            </div>
                        </dl>

                        <div class="pro-details-actions d-flex flex-wrap align-items-stretch gap-3 mt-4 pt-2">
                            @if ($canPurchase)
                                <button type="button" onclick="AddToCart({{ $product->id }})" title="Add To Cart"
                                    class="add-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
                                    Add to cart
                                </button>
                            @endif
                            <button type="button" class="add-wishlist" title="Add to wishlist"
                                onclick="AddToWishlist({{ $product->id }})" aria-label="Add to wishlist">
                                <i class="pe-7s-like" aria-hidden="true"></i>
                                <span>Add to wishlist</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 mt-lg-5">
                <div class="col-12">
                    <div class="pdp-tabs-section description-review-wrapper">
                        <ul class="nav nav-tabs description-review-topbar pdp-tabs-nav border-0 gap-2 flex-wrap"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-4 py-2" id="tab-des-info" type="button" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#des-details2" aria-controls="des-details2"
                                    aria-selected="true">Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-4 py-2" id="tab-des-desc" type="button" role="tab"
                                    data-bs-toggle="tab" data-bs-target="#des-details1" aria-controls="des-details1"
                                    aria-selected="false">Description</button>
                            </li>
                        </ul>
                        <div
                            class="tab-content description-review-bottom pdp-tab-panel border border-top-0 rounded-bottom p-3 p-md-4 p-lg-5 bg-white">
                            <div id="des-details2" class="tab-pane fade show active" role="tabpanel"
                                aria-labelledby="tab-des-info" tabindex="0">
                                <div class="product-anotherinfo-wrapper text-start">
                                    <ul class="mb-0">
                                        <li><span>Weight</span> {{ $product->product_weight ?? '—' }} g</li>
                                        <li><span>Other info</span>
                                            {{ $product->other_info ? strip_tags($product->other_info) : '—' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details1" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-des-desc"
                                tabindex="0">
                                <div class="product-description-wrapper">
                                    @if ($product->long_description)
                                        <div class="pdp-long-desc text-start text-muted">
                                            {!! nl2br(e(strip_tags($product->long_description))) !!}
                                        </div>
                                    @else
                                        <p class="mb-0 text-start text-muted">No description available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area related-product pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center m-0">
                        <h2 class="title">Related products</h2>
                        <p class="text-muted mb-0">More from the same category</p>
                    </div>
                </div>
            </div>

            @if ($relatedProducts->isNotEmpty())
                <div class="row mt-4">
                    <div class="col">
                        <div class="new-product-slider swiper-container slider-nav-style-1">
                            <div class="swiper-wrapper">
                                @foreach ($relatedProducts as $item)
                                    <div class="swiper-slide">
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="{{ route('product.detail', $item->id) }}" class="image">
                                                    <img src="{{ asset('images/products/thumbnail/' . $item->product_thumbnail) }}"
                                                        alt="{{ $item->product_name }}" />
                                                    <img class="hover-image"
                                                        src="{{ asset('images/products/thumbnail/' . $item->product_thumbnail) }}"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="content">
                                                @if ($item->category)
                                                    <span class="category">
                                                        <a
                                                            href="{{ route('category.wise.product', $item->category_id) }}">{{ $item->category->category_name }}</a>
                                                    </span>
                                                @else
                                                    <span class="category text-muted">—</span>
                                                @endif
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
                                                            Rs. {{ number_format($sellingPrice, 2) }}
                                                        </span>
                                                    @endif
                                                    <span class="new fw-bold text-danger">
                                                        Rs. {{ number_format($finalPrice, 2) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="actions">
                                                <button type="button" title="Add To Cart" class="action add-to-cart"
                                                    onclick="AddToCart({{ $item->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal-Cart">
                                                    <i class="pe-7s-shopbag"></i>
                                                </button>
                                                <button type="button" onclick="AddToWishlist({{ $item->id }})"
                                                    class="action wishlist" title="Wishlist">
                                                    <i class="pe-7s-like"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-buttons">
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-light border text-center py-5" role="alert">
                            <i class="fa fa-layer-group fa-2x d-block mb-3 text-muted" aria-hidden="true"></i>
                            <h5 class="fw-semibold mb-1">No related products</h5>
                            <p class="mb-0 text-muted small">Browse the shop for more items.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
