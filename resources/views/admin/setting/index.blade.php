@extends('admin.layout')
@section('main')
@section('page-title')
    Site Settings
@endsection
<div class="card">
    <div class="card-header py-3 bg-dark text-white">
        <h6 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Update Setting</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('settings.update', $setting->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Left Partition - Company Information -->
                <div class="col-12 col-lg-6">
                    <div class="card border shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-building me-2"></i>Company Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-image me-1"></i>Site Logo</label>
                                    <input type="file" name="logo"
                                        class="form-control @error('logo') is-invalid @enderror"
                                        id="image_upload_input">
                                    <img src="{{ asset('images/setting/' . $setting->logo) }}" id="image_preview_tag"
                                        alt="Image Preview" class="mt-2 rounded" width="150">
                                    @error('logo')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-building me-1"></i>Company Name</label>
                                    <input type="text"
                                        class="form-control @error('company_name') is-invalid @enderror"
                                        name="company_name" placeholder="Enter company name"
                                        value="{{ $setting->company_name }}">
                                    @error('company_name')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Company
                                        Address</label>
                                    <input type="text"
                                        class="form-control @error('company_address') is-invalid @enderror"
                                        name="company_address" placeholder="Enter company address"
                                        value="{{ $setting->company_address }}">
                                    @error('company_address')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-telephone-fill me-1"></i>Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Enter phone number" value="{{ $setting->phone }}">
                                    @error('phone')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Enter email address" value="{{ $setting->email }}">
                                    @error('email')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i
                                            class="bi bi-text-paragraph me-1"></i>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="4" name="description"
                                        placeholder="Enter company description">{{ $setting->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Partition - Social Media Links -->
                <div class="col-12 col-lg-6">
                    <div class="card border shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-share me-2"></i>Social Media Links</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-facebook me-1"></i>Facebook</label>
                                    <input type="url" class="form-control @error('facebook') is-invalid @enderror"
                                        name="facebook" placeholder="Enter Facebook URL"
                                        value="{{ $setting->facebook }}">
                                    @error('facebook')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-twitter-x me-1"></i>X (Twitter)</label>
                                    <input type="url" class="form-control @error('x') is-invalid @enderror"
                                        name="x" placeholder="Enter X (Twitter) URL" value="{{ $setting->x }}">
                                    @error('x')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-linkedin me-1"></i>LinkedIn</label>
                                    <input type="url" class="form-control @error('linkedin') is-invalid @enderror"
                                        name="linkedin" placeholder="Enter LinkedIn URL"
                                        value="{{ $setting->linkedin }}">
                                    @error('linkedin')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-youtube me-1"></i>YouTube</label>
                                    <input type="url" class="form-control @error('youtube') is-invalid @enderror"
                                        name="youtube" placeholder="Enter YouTube URL"
                                        value="{{ $setting->youtube }}">
                                    @error('youtube')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i>Update Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
