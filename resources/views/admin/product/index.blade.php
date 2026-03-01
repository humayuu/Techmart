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
                            <table class="table align-middle" id="productTable">
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
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
