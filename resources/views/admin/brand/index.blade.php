@extends('admin.layout');
@section('main')
@section('page-title')
    Brands
@endsection
<div class="card">
    <div class="card-header py-3">
        <h6 class="mb-0">Add Product Brands</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        @if ($errors->all())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('brand.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Brand name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" cols="3" name="description" placeholder="Brand Description"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Brand logo</label>
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary">Add Brand</button>
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
                            @if ($brands->count() > 0)
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 25%;">Description</th>
                                            <th style="width: 30%;">Brand Logo</th>
                                            <th style="width: 25%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $brands->firstItem() + $loop->index }}</td>
                                                <td>{{ $brand->brand_name }}</td>
                                                <td>{{ Str::substr($brand->brand_description, 0, 20) }}.....</td>
                                                <td><img class="w-50" src="{{ asset($brand->brand_logo) }}">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3 fs-6">

                                                        <a href="{{ route('brand.edit', $brand->id) }}"
                                                            class="text-primary" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title=""
                                                            data-bs-original-title="Edit info" aria-label="Edit"><i
                                                                class="bi bi-pencil-fill"></i></a>

                                                        <a href="javascript:;" class="text-danger"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                        <nav class="float-end mt-0" aria-label="Page navigation">
                            {{-- <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul> --}}
                            {{ $brands->links() }}
                        </nav>
                    @else
                        <div class="alert alert-danger" role="alert">
                            No Brand Found!
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>

@endsection
