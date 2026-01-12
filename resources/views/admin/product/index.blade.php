@extends('admin.layout');
@section('main')
@section('page-title')
    Products <span class="badge text-bg-dark">{{ $totalProducts }}</span>
@endsection
<div class="card">
    <div class="card-body">
        {{-- Create Button --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('product.create') }}" class="btn btn-primary fs-5">
                <i class="bi bi-plus"></i> Add Product
            </a>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($products->count() > 0)
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20%;">Product Image</th>
                                            <th style="width: 15%;">Product Name</th>
                                            <th style="width: 15%;">Brand</th>
                                            <th style="width: 12%;">Category</th>
                                            <th style="width: 13%;">Selling Price</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 25%;">Action</th>
                                        </tr>
                                    </thead>
                            @endif
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <img class="w-50 img-thumbnail rounded"
                                                src="{{ asset('images/products/' . $product->product_thumbnail) }}"
                                                alt="{{ $product->product_thumbnail }}">
                                        </td>
                                        <td class="fw-semibold">{{ $product->product_name }}</td>
                                        <td class="h5 text-primary">{{ $product->brand->brand_name }}</td>
                                        <td class="h6">{{ $product->category->category_name }}</td>
                                        <td class="fs-5 fw-bold">Rs.
                                            {{ number_format($product->selling_price, 2) }}</td>
                                        <td>
                                            @php
                                                $status = $product->status == 'active' ? 'Active' : 'Inactive';
                                                $class = $product->status == 'active' ? 'success' : 'dark';
                                                $icon = $product->status == 'active' ? 'thumbs-up' : 'thumbs-down';
                                            @endphp

                                            <span
                                                class="badge text-bg-{{ $class }} fs-6">{{ $status }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-5">

                                                <!-- View Record -->
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="text-secondary fs-4 " data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="View Info">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>

                                                <!-- Update Status Button -->
                                                <a href="{{ route('product.status', $product->id) }}"
                                                    class="text-{{ $class }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Update Status">
                                                    <i class="bi bi-hand-{{ $icon }}-fill"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="text-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Edit info">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                    method="POST" class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="delete" type="submit"
                                                        class="text-danger border-0 bg-transparent p-0 d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Delete" style="cursor: pointer; line-height: 1;">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        No Product Found!
                                    </div>
                                @endforelse
                            </tbody>
                            </table>
                        </div>
                        {{-- Pagination --}}
                        <nav class="float-end mt-0" aria-label="Page navigation">
                            {{ $products->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
