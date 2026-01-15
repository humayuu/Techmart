@extends('admin.layout');
@section('main')
@section('page-title')
    Category <span class="badge text-bg-dark">{{ $totalCategories }}</span>
@endsection
<div class="card">
    <div class="card-header py-3 bg-secondary text-white">
        <h6 class="mb-0">Add Product Category</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">

                        <form method="POST" action="{{ route('category.store') }}" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                    name="category_name" placeholder="Category name">
                                @error('category_name')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary">Add Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle" id="categoryTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 25%;">Slug</th>
                                        <th style="width: 25%;">Action</th>
                                    </tr>
                                </thead>
                                <!-- DataTables will populate this -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
