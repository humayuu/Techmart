@extends('admin.layout')
@section('main')
@section('page-title')
    Products
@endsection

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <h6 class="mb-0">View Product Information</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Basic Information -->
            <div class="col-12 mb-3">
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product Brand <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" disabled>
                                    <option value="">Select Brand</option>
                                    @forelse ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : null }}>
                                            {{ $brand->brand_name }}</option>
                                    @empty
                                        <div class="alert alert-danger">No brand Found!</div>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" disabled>
                                    <option value="">Select Category</option>
                                    @forelse ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : null }}>
                                            {{ $category->category_name }}</option>
                                    @empty
                                        <div class="alert alert-danger">No category Found!</div>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $product->product_name }}"
                                    disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Product Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $product->product_code }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card border h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Pricing & Inventory</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-bold">Selling Price <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" disabled
                                        value="{{ $product->selling_price }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Discount Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" disabled
                                        value="{{ $product->discount_price }}">
                                </div>
                                <small class="text-muted">Optional</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" disabled
                                    value="{{ $product->product_qty }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Weight</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $product->product_weight }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Tags -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card border h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Description & Tags</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-bold">Tags</label>
                                <input type="text" class="form-control" data-role="tagsinput"
                                    value="{{ $product->product_tags }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea class="form-control" rows="3" disabled>{{ $product->short_description }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Long Description</label>
                                <textarea class="form-control" rows="4" disabled>{{ strip_tags($product->long_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Upload -->
            <div class="col-12 mb-3">
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Product Images</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Thumbnail <span class="text-danger">*</span></label>
                                <input type="file" class="form-control mb-2" disabled>
                                <img class="w-25 img-thumbnail" src="{{ asset($product->product_thumbnail) }}"
                                    alt="{{ $product->product_thumbnail }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Additional Images</label>
                                <input type="file" class="form-control mb-2" disabled>
                                @php
                                    $images = json_decode($product->product_multiple_image);
                                @endphp
                                @if ($images)
                                    @foreach ($images as $img)
                                        <img class="w-25 img-thumbnail" src="{{ asset($img) }}"
                                            alt="{{ $img }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Settings -->
            <div class="col-12 mb-3">
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Additional Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label fw-bold">Other Information</label>
                                <textarea class="form-control" rows="4" disabled>{{ $product->other_info }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input fs-6" type="checkbox" role="switch"
                                            name="is_featured" {{ $product->featured == 1 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label">
                                            <span class="fw-bold fs-6">Featured Product</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input fs-6" type="checkbox" role="switch"
                                            {{ $product->special_offer == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">
                                            <span class="fw-bold fs-6">Special Offer</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Product Page -->
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-start border-top pt-3 mt-3">
                    <a class="btn btn-lg btn-primary" href="{{ route('product.index') }}">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
