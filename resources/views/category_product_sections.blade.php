@php
    $categoryProductSections = $categoryProductSections ?? collect();
@endphp
@if ($categoryProductSections->isNotEmpty())
    <div class="product-area category-product-sections pb-100px pt-40px">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title mb-2">Shop by category</h2>
                        <p class="text-muted mb-0">Browse our newest items grouped by category</p>
                    </div>
                </div>
            </div>

            @foreach ($categoryProductSections as $category)
                @continue($category->products->isEmpty())
                <section class="category-product-block mb-5 pb-4 border-bottom border-light"
                    aria-labelledby="category-heading-{{ $category->id }}">
                    <div class="row align-items-end g-3 mb-3 mb-md-4">
                        <div class="col">
                            <div class="section-title mb-0 text-start">
                                <h3 id="category-heading-{{ $category->id }}" class="title mb-0 h4">
                                    {{ $category->category_name }}
                                </h3>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('category.wise.product', $category->id) }}"
                                class="btn btn-outline-dark btn-sm px-3">
                                View all
                            </a>
                        </div>
                    </div>

                    <div class="tab-content mt-30px">
                        <div class="tab-pane fade show active">
                            <div class="row mb-n-30px">
                                @foreach ($category->products as $product)
                                    <div class="col-lg-3 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="{{ route('product.detail', $product->id) }}" class="image">
                                                    <img src="{{ $product->image_url }}"
                                                        alt="{{ $product->product_name }}" />
                                                    <img class="hover-image" src="{{ $product->image_url }}"
                                                        alt="" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <span class="category">
                                                    <a
                                                        href="{{ route('category.wise.product', $category->id) }}">{{ $category->category_name }}</a>
                                                </span>
                                                <h5 class="title" style="min-height: 3rem;">
                                                    <a href="{{ route('product.detail', $product->id) }}"
                                                        class="d-block"
                                                        style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; white-space: normal;">{{ Str::limit($product->product_name, 50) }}</a>
                                                </h5>
                                                <span class="price mt-auto">
                                                    @if ($product->discount_price > 0)
                                                        <span
                                                            class="old text-muted text-decoration-line-through me-2">${{ number_format((float) $product->selling_price, 2) }}</span>
                                                    @endif
                                                    <span
                                                        class="new fw-bold">${{ number_format((float) $product->price, 2) }}</span>
                                                </span>
                                            </div>
                                            <div class="actions d-flex justify-content-center gap-2 mt-3">
                                                <button type="button" onclick="AddToCart({{ $product->id }})"
                                                    title="Add To Cart" class="action add-to-cart btn btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
                                                    <i class="pe-7s-shopbag"></i>
                                                </button>
                                                <button type="button" onclick="AddToWishlist({{ $product->id }})"
                                                    class="action wishlist btn btn-sm" title="Wishlist">
                                                    <i class="pe-7s-like"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </div>
@endif
