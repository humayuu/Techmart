@extends('layout')

@section('main')
    <div class="container py-5">

        <h5 class="mb-4">
            Results for "<strong>{{ $query }}</strong>"
            — {{ $products->total() }} products found
        </h5>

        @if ($products->isEmpty())
            <p class="text-muted">No products found. Try another keyword.</p>
        @else
            <div class="row g-3">
                @foreach ($products as $product)
                    <div class="col-6 col-md-3">
                        <a href="/products/{{ $product->id }}" class="text-decoration-none text-dark">
                            <div class="card border-0 shadow-sm h-100">

                                <img src="{{ asset('storage/' . $product->product_thumbnail) }}"
                                    alt="{{ $product->product_name }}" style="height:200px; object-fit:cover;"
                                    class="card-img-top">

                                <div class="card-body p-3">
                                    <p class="mb-1 fw-semibold text-truncate">
                                        {{ $product->product_name }}
                                    </p>
                                    <p class="mb-0 text-primary fw-bold">
                                        ${{ number_format($product->selling_price, 2) }}
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
