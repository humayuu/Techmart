@extends('admin.layout')

@section('page-title')
    Admin User Change Password
@endsection

@section('main')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="bi bi-person-circle me-2"></i>Update User Password
                            </h5>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-10">
                                    <!-- Change Password -->
                                    <div class="card border mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-dark">
                                                <i class="bi bi-gear me-2"></i>Change Password
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <!-- Password Fields -->
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-semibold">
                                                    Current Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                    class="form-control form-control-lg @error('current_password') is-invalid @enderror"
                                                    name="current_password" placeholder="Current Password" autofocus>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-semibold">
                                                    New Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    name="password" placeholder="New Password">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-semibold">
                                                    Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <input type="password"
                                                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation" placeholder="Confirm Password">
                                                @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card border-0 bg-light">
                                        <div class="card-body p-4">
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                                <div class="mb-3 mb-sm-0">
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
