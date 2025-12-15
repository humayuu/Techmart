@extends('admin.layout');
@section('main')
@section('page-title')
    Category
@endsection
<div class="card">
    <div class="card-header py-3">
        <h6 class="mb-0">Edit Product Category</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-8 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('category.update', $category->id) }}" class="row g-3">
                            @csrf
                            @method('PUT')

                            <div class="col-12">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name"
                                    placeholder="Category name" value="{{ $category->category_name }}">
                            </div>
                            <div class="col-12">
                                <div class="">
                                    <button class="btn btn-primary">Save Changes</button>
                                    <a class="btn btn-outline-dark" href="{{ route('category.index') }}">Cancel</a>
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
