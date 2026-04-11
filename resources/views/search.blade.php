@extends('layout')

@section('main')
    <div class="container py-5 search-results-page">

        <h5 class="mb-4">
            Results for "<strong>{{ $query }}</strong>"
            — {{ $products->total() }} products found
        </h5>

        @if ($products->isEmpty())
            <p class="text-muted">No products found. Try another keyword.</p>
        @else
            <div class="row g-3">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('product.detail', $product->id) }}"
                            class="text-decoration-none text-dark search-product-card d-block h-100">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="search-product-thumb rounded-top">
                                    <img src="{{ asset('images/products/thumbnail/' . $product->product_thumbnail) }}"
                                        alt="{{ $product->product_name }}">
                                </div>
                                <div class="card-body p-3 d-flex flex-column">
                                    <p class="mb-2 fw-semibold small" style="min-height: 2.6rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $product->product_name }}
                                    </p>
                                    <p class="mb-0 text-primary fw-bold mt-auto">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->appends(['q' => $query])->links() }}
            </div>
        @endif

    </div>
@endsection
