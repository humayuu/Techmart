@extends('layout')
@section('main')
    <div class="container py-5" style="max-width: 860px;">

        {{-- Back Button --}}
        <a href="{{ url()->previous() }}" class="fs-4"><i class="fa-solid fa-arrow-left-long"></i> Back
        </a>

        {{-- Header --}}
        <h1 class="fw-bold text-primary text-center mb-5">Order Detail</h1>

        {{-- Products --}}
        @forelse ($orderProducts->orderProducts as $index => $order)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    Product #{{ $index + 1 }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center gap-3">
                        <span class="fw-semibold text-muted" style="width: 120px;">Image</span>
                        <img src="{{ asset('images/product/' . $order->product_image) }}" alt="{{ $order->product_name }}"
                            class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <span class="fw-semibold text-muted" style="width: 120px;">Product Name</span>
                        <span>{{ $order->product_name }}</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <span class="fw-semibold text-muted" style="width: 120px;">Quantity</span>
                        <span class="badge bg-secondary">{{ $order->quantity }}</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <span class="fw-semibold text-muted" style="width: 120px;">Unit Price</span>
                        <span>Rs. {{ number_format($order->unit_price, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <span class="fw-semibold text-muted" style="width: 120px;">Sub Total</span>
                        <span class="fw-bold text-primary">Rs. {{ number_format($order->sub_total, 2) }}</span>
                    </li>
                </ul>
            </div>

        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bag-x fs-1 d-block mb-3"></i>
                <p class="fs-5">No products found for this order.</p>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-2">Go Back</a>
            </div>
        @endforelse

    </div>
@endsection
