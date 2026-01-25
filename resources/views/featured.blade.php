@php
    $featuredProducts = \App\Models\Product::where('featured', true)->inRandomOrder()->take(3)->get();
@endphp

<!-- Feature product area start -->
<div class="feature-product-area pt-100px pb-100px">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title mb-2">Featured Offers</h2>
                    <p class="text-muted">Discover our handpicked selection of amazing products</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @forelse ($featuredProducts as $product)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card border-0 shadow h-100">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('images/products/' . $product->product_thumbnail) }}"
                                class="card-img-top w-100" style="height: 280px; object-fit: cover;"
                                alt="{{ $product->product_name }}" />
                            @if ($product->discount_price > 0)
                                @php
                                    $discountPercent = round(
                                        ($product->discount_price / $product->selling_price) * 100,
                                    );
                                @endphp
                                <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">
                                    -{{ $discountPercent }}%
                                </span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column bg-dark text-white p-4">
                            <h5 class="card-title mb-3 fw-bold">
                                <a href="single-product.html" class="text-white text-decoration-none stretched-link">
                                    {{ Str::limit($product->product_name, 50) }}
                                </a>
                            </h5>
                            <div class="mt-auto mb-3">
                                @if ($product->discount_price > 0)
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <span class="h4 mb-0 text-white fw-bold">
                                            @php
                                                $total = $product->selling_price - $product->discount_price;
                                            @endphp
                                            ${{ number_format($total, 2) }}
                                        </span>
                                        <span class="text-decoration-line-through text-white-50 fs-6">
                                            ${{ number_format($product->selling_price, 2) }}
                                        </span>
                                    </div>
                                    <small class="text-success d-block mt-1">
                                        Save ${{ number_format($product->discount_price, 2) }}
                                    </small>
                                @else
                                    <span class="h4 mb-0 text-white fw-bold">
                                        ${{ number_format($product->selling_price, 2) }}
                                    </span>
                                @endif
                            </div>
                            <a href="single-product-variable.html" class="btn btn-primary w-100 py-2 position-relative"
                                style="z-index: 2;">
                                <i class="bi bi-cart-plus me-2"></i>Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5" role="alert">
                        <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                        <h5>No Featured Products Available</h5>
                        <p class="mb-0">Check back soon for our latest featured offers!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Feature product area End -->
