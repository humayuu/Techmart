@extends('admin.layout')
@section('page-title')
    Products Stock
@endsection
@section('main')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="mb-0">Add Product Stock</h6>
        </div>
        <div class="card-body">

            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-12 mb-3">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Product<span class="text-danger">*</span></label>
                                        <select class="form-select @error('product_id') is-invalid @enderror"
                                            name="product_id">
                                            <option selected disabled>Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product')
                                            <span class="text-danger fs-6">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Add Stock<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                            name="stock" placeholder="Enter Stock" value="{{ old('stock') }}">
                                        @error('stock')
                                            <span class="text-danger fs-6">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-end border-top pt-3">
                                            <a class="btn btn-outline-secondary"
                                                href="{{ route('stock.index') }}">Cancel</a>
                                            <button type="submit" class="btn btn-primary px-4">Add Stock</button>
                                        </div>
                                    </div>
                                </div>
            </form>
        </div>
    </div>
@endsection
