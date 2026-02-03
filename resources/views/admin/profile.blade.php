@extends('admin.layout')

@section('page-title')
    Admin User Detail
@endsection

@section('main')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="bi bi-person-circle me-2"></i>Update User Details
                            </h5>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-8">
                                    <!-- User Information Section -->
                                    <div class="card border mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-dark">
                                                <i class="bi bi-info-circle me-2"></i>Personal Information
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <!-- Name Field -->
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-semibold">
                                                    Full Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                    id="name" name="name" placeholder="Enter full name"
                                                    value="{{ old('name', $user->name) }}" required autofocus>
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-text">
                                                    <i class="bi bi-info-circle me-1"></i>Enter the user's full name
                                                </div>
                                            </div>

                                            <!-- Email Field -->
                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-semibold">
                                                    Email Address <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text bg-light">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" placeholder="user@example.com"
                                                        value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-text">
                                                    <i class="bi bi-info-circle me-1"></i>Used for login and notifications
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card border-0 bg-light">
                                        <div class="card-body p-4">
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                                <div class="mb-3 mb-sm-0">
                                                    <small class="text-muted">
                                                        <i class="bi bi-shield-check me-1"></i>
                                                        All changes will be logged
                                                    </small>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.dashboard') }}"
                                                        class="btn btn-outline-secondary">Cancel
                                                    </a>
                                                    <button type="submit" class="btn btn-primary px-4">Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
