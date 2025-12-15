@extends('admin.layout');
@section('main')
@section('page-title')
    Category
@endsection
<div class="card">
    <div class="card-header py-3">
        <h6 class="mb-0">Add Product Category</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
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

                        <form method="POST" action="{{ route('category.store') }}" class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name"
                                    placeholder="Category name">
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
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 25%;">Slug</th>
                                        <th style="width: 25%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $loop->index }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>{{ $category->category_slug }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3 fs-6">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('category.edit', $category->id) }}"
                                                        class="text-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="Edit info">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form method="POST"
                                                        action="{{ route('category.destroy', $category->id) }}"
                                                        class="d-inline m-0">
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
                                            No Brand Found!
                                        </div>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <nav class="float-end mt-0" aria-label="Page navigation">
                            {{ $categories->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
