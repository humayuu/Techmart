@extends('admin.layout')
@section('main')
@section('page-title')
    Products
@endsection

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $product->product_name }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                            <li class="breadcrumb-item active">{{ $product->product_code }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Images -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <!-- Main Thumbnail -->
                    <div class="position-relative bg-light p-4 text-center">
                        <img src="{{ asset('images/products/' . $product->product_thumbnail) }}"
                            class="img-fluid rounded" alt="{{ $product->product_name }}">

                        <!-- Status Badges Overlay -->
                        <div class="position-absolute top-0 start-0 p-3">
                            @if ($product->featured == 1)
                                <span class="badge bg-warning text-dark mb-1 d-block">
                                    <i class="bi bi-star-fill"></i> Featured
                                </span>
                            @endif
                            @if ($product->special_offer == 1)
                                <span class="badge bg-danger d-block">
                                    <i class="bi bi-tag-fill"></i> Special Offer
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Images Gallery -->
                    @php
                        $images = json_decode($product->product_multiple_image);
                    @endphp
                    @if ($images && count($images) > 0)
                        <div class="p-3 border-top">
                            <h6 class="text-muted mb-3">Additional Images</h6>
                            <div class="row g-2">
                                @foreach ($images as $img)
                                    <div class="col-3">
                                        <img src="{{ asset('images/products/' . $img) }}" class="img-thumbnail w-100"
                                            alt="Product image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="col-lg-7">
            <!-- Pricing Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="text-muted mb-1 small">PRICE</p>
                            @if ($product->discount_price)
                                @php
                                    $finalPrice = $product->selling_price - $product->discount_price;
                                    $discountPercent = round(
                                        ($product->discount_price / $product->selling_price) * 100,
                                    );
                                @endphp
                                <h3 class="mb-0 text-danger fw-bold">
                                    ${{ number_format($finalPrice, 2) }}
                                </h3>
                                <div class="mt-2">
                                    <span class="text-decoration-line-through text-muted me-2">
                                        ${{ number_format($product->selling_price, 2) }}
                                    </span>
                                    <span class="badge bg-danger">
                                        {{ $discountPercent }}% OFF
                                    </span>
                                </div>
                            @else
                                <h3 class="mb-0 text-success fw-bold">
                                    ${{ number_format($product->selling_price, 2) }}
                                </h3>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <p class="text-muted mb-1 small">STOCK QUANTITY</p>
                            <h4 class="mb-0">
                                <span
                                    class="badge {{ $product->product_qty > 10 ? 'bg-success' : 'bg-warning text-dark' }} fs-5">
                                    {{ $product->product_qty }} Units
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Product Code</div>
                        <div class="col-8 fw-semibold">{{ $product->product_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Brand</div>
                        <div class="col-8 fw-semibold">{{ $product->brand->brand_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Category</div>
                        <div class="col-8 fw-semibold">{{ $product->category->category_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Weight</div>
                        <div class="col-8 fw-semibold">{{ $product->product_weight ?? 'N/A' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted">Tags</div>
                        <div class="col-8">
                            @if ($product->product_tags)
                                @foreach (explode(',', $product->product_tags) as $tag)
                                    <span class="badge bg-secondary me-1 mb-1">{{ trim($tag) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No tags</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Tabs -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#details">Additional Details</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description">
                            <h6 class="fw-bold mb-2">Short Description</h6>
                            <p class="text-muted mb-4">
                                {{ $product->short_description ?? 'No short description available.' }}
                            </p>

                            <h6 class="fw-bold mb-2">Full Description</h6>
                            <p class="text-muted mb-0">
                                {{ strip_tags($product->long_description) ?? 'No detailed description available.' }}
                            </p>
                        </div>

                        <!-- Additional Details Tab -->
                        <div class="tab-pane fade" id="details">
                            <h6 class="fw-bold mb-2">Other Information</h6>
                            <p class="text-muted mb-0">
                                {{ $product->other_info ?? 'No additional information available.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
