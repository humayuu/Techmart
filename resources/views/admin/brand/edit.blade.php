@extends('admin.layout');
@section('main')
@section('page-title')
    Brands
@endsection
<div class="card">
    <div class="card-header py-3">
        <h6 class="mb-0">Edit Product Brands</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-8 d-flex">
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
                        <form method="POST" action="{{ route('brand.update', $brand->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')

                            <div class="col-12">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Brand name"
                                    value="{{ $brand->brand_name }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" cols="3" name="description" placeholder="Brand Description">{{ $brand->brand_description }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Brand logo</label>
                                <input type="file" name="logo" class="form-control">
                                <img class="w-100 mt-2 img-thumbnail" src="{{ asset($brand->brand_logo) }}"
                                    alt="">
                            </div>

                            <div class="col-12">
                                <div class="">
                                    <button class="btn btn-primary">Save Changes</button>
                                    <a class="btn btn-outline-dark" href="{{ route('brand.index') }}">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>

@endsection
