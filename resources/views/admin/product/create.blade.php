@extends('admin.layout')
@section('main')
@section('page-title')
    Products
@endsection

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <h6 class="mb-0">Add New Product</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Basic Information -->
                <div class="col-12 mb-3">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Product Brand <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="brand">
                                        <option selected disabled>Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Product Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="category">
                                        <option selected disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="product_name"
                                        placeholder="Enter product name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Product Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="product_code"
                                        placeholder="Enter product code" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="col-12 col-lg-6 mb-3">
                    <div class="card border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Pricing & Inventory</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Selling Price <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control" name="selling_price"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Discount Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control" name="discount_price"
                                            placeholder="0.00">
                                    </div>
                                    <small class="text-muted">Optional</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Quantity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="quantity"
                                        placeholder="Enter quantity">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Weight</label>
                                    <input type="text" class="form-control" name="weight"
                                        placeholder="e.g., 500g, 1kg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Tags -->
                <div class="col-12 col-lg-6 mb-3">
                    <div class="card border h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Description & Tags</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Tags</label>
                                    <input type="text" class="form-control visually-hidden" name="tags"
                                        data-role="tagsinput" placeholder="Enter Product Tags">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Short Description</label>
                                    <textarea class="form-control" name="short_description" rows="3" placeholder="Brief summary"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Long Description</label>
                                    <textarea class="form-control" id="long_description" name="long_description" placeholder="Detailed information"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Upload -->
                <div class="col-12 mb-3">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Product Images</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Thumbnail <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="image_upload_input"
                                        name="thumbnail" accept="image/*">
                                    <small class="text-muted">Main product image</small>
                                    <img src="#" id="image_preview_tag" alt="Image Preview" width="150"
                                        style="display: none;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Additional Images</label>
                                    <input type="file" class="form-control" id="imageInput" name="images[]"
                                        accept="image/*" multiple>
                                    <small class="text-muted">Select multiple images (Max 5)</small>
                                    <div id="multiplePreview" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="col-12 mb-3">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Additional Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Other Information</label>
                                    <textarea class="form-control" id="other_info" name="other_info" rows="4"
                                        placeholder="Additional details, specifications, warranty info"></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded p-3 bg-light">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch"
                                                name="is_featured" value="1" id="featuredCheck">
                                            <label class="form-check-label" for="featuredCheck">
                                                <span class="fw-bold fs-6">Featured Product</span>
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch"
                                                name="special_offer" value="1" id="specialOfferCheck">
                                            <label class="form-check-label" for="specialOfferCheck">
                                                <span class="fw-bold fs-6">Special Offer</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-end border-top pt-3">
                        <a class="btn btn-outline-secondary" href="{{ route('product.index') }}">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Add Product</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TinyMCE Editor --}}
<script src="https://cdn.tiny.cloud/1/ipecvicv0hfws0f638gkuupueg2moq5pzadav0h1edc0g2dq/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#long_description',
        height: 300,
        plugins: ['lists', 'link', 'image', 'table', 'code', 'wordcount', 'preview'],
        toolbar: 'undo redo | formatselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code preview',
        menubar: false,
        branding: false,
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
    });

    // Thumbnail & multiple image preview

    document.getElementById('image_upload_input').onchange = function(e) {
        let reader = new FileReader();
        reader.onload = function(event) {
            let img = document.getElementById('image_preview_tag');
            img.src = event.target.result;
            img.style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    }

    document.getElementById('imageInput').onchange = function(e) {
        let files = e.target.files;
        let previewContainer = document.getElementById('multiplePreview');
        previewContainer.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            let reader = new FileReader();
            reader.onload = function(event) {
                let img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '120px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(files[i]);
        }
    }
</script>
@endsection
