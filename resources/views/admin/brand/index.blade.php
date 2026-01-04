@extends('admin.layout');
@section('main')
@section('page-title')
    Brands <span class="badge text-bg-dark">{{ $totalBrands }}</span>
@endsection
<div class="card">
    <div class="card-header py-3 bg-dark text-white">
        <h6 class="mb-0">Add Product Brands</h6>
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

                        <form method="POST" action="{{ route('brand.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Brand name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" cols="3" name="description" placeholder="Brand Description">{{ old('description') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Brand logo</label>
                                <input type="file" name="logo" class="form-control" id="image_upload_input">
                                <img src="#" id="image_preview_tag" alt="Image Preview" width="150"
                                    style="display: none;">
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
                                <table class="table align-middle" id="brandTable">
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
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $brand->brand_name }}</td>
                                                <td>{{ Str::substr($brand->brand_description, 0, 20) }}.....</td>
                                                <td><img class="w-50" src="{{ asset($brand->brand_logo) }}">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3 fs-5">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('brand.edit', $brand->id) }}"
                                                            class="text-primary" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Edit info">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('brand.destroy', $brand->id) }}"
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
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
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

<script>
    document.getElementById('image_upload_input').onchange = function(e) {
        let reader = new FileReader();
        reader.onload = function(event) {
            let img = document.getElementById('image_preview_tag');
            img.src = event.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    }
</script>
@endsection
