@extends('admin.layout')

@section('page-title')
    Admin User Detail
@endsection

@section('main')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-7 col-xl-7">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>Update User Details
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter full name"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="user@example.com"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Profile Image --}}
                            <div class="mb-4">
                                <label for="profile_image" class="form-label fw-semibold">
                                    Profile Image
                                </label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                                    id="image_upload_input" name="profile_image" accept="image/*">

                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Current image preview --}}
                                <div class="mt-2">
                                    @if (!empty($user->profile_image))
                                        <img id="image_preview_tag"
                                            src="{{ asset('images/profile_image/' . $user->profile_image) }}"
                                            alt="Current profile" class="img-thumbnail rounded-5 w-25">
                                    @else
                                        <img id="image_preview_tag" src="{{ asset('default-avatar.png') }}"
                                            alt="Default avatar" class="img-thumbnail rounded-5 w-25">
                                    @endif

                                    <small class="text-muted d-block mt-1">Current profile image</small>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-lg me-1"></i>Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
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
