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
                        <form method="POST" action="{{ route('brand.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Brand name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('name') is-invalid @enderror" rows="3" cols="3" name="description"
                                    placeholder="Brand Description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Brand logo</label>
                                <input type="file" name="logo"
                                    class="form-control @error('logo') is-invalid @enderror" id="image_upload_input">
                                <img src="#" id="image_preview_tag" alt="Image Preview" width="150"
                                    style="display: none;">
                                @error('logo')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
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
                                <!-- DataTables will populate this -->
                            </table>
                        </div>
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
