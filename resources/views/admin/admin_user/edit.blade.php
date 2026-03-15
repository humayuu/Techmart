@extends('admin.layout')
@section('main')
    <div class="card shadow-sm border-0 rounded-3">

        {{-- Header --}}
        <div class="card-header bg-dark text-white px-4 py-3 rounded-top-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user-plus"></i>
                <h6 class="mb-0 fw-semibold">Edit Admin User</h6>
            </div>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.user.update', $adminUser->id) }}">
                @csrf
                @method('PUT')

                {{-- SECTION: Basic Info   --}}
                <div class="border rounded-3 mb-4">

                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light border-bottom rounded-top-3">
                        <i class="fas fa-circle-info text-secondary"></i>
                        <span class="fw-semibold text-secondary text-uppercase">Basic Information</span>
                    </div>

                    <div class="p-3">
                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="name" name="name" placeholder="Enter full name"
                                    class="form-control @error('name') is-invalid @enderror" autofocus
                                    value="{{ $adminUser->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ $adminUser->email }}"
                                    placeholder="Enter email address"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Role --}}
                            <div class="col-md-4">
                                <label for="role" class="form-label fw-semibold">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <select id="role" name="role"
                                    class="form-select @error('role') is-invalid @enderror">
                                    <option value="" disabled selected>— Select Role —</option>
                                    <option value="admin" {{ $adminUser->role == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="normal_user" {{ $adminUser->role == 'normal_user' ? 'selected' : '' }}>
                                        Normal
                                        User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- SECTION: Access Permissions --}}
                {{-- ========================= --}}
                <div class="border rounded-3 mb-4">

                    <div
                        class="d-flex align-items-center justify-content-between px-3 py-2 bg-light border-bottom rounded-top-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-shield-halved text-secondary"></i>
                            <span class="fw-semibold text-secondary text-uppercase">Access Permissions</span>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-semibold text-secondary" for="selectAll">
                                Select All
                            </label>
                        </div>
                    </div>

                    <div class="p-3">

                        @error('access')
                            <div class="alert alert-danger py-2 px-3 mb-3">
                                <i class="fas fa-circle-exclamation me-1"></i> {{ $message }}
                            </div>
                        @enderror

                        @php
                            $modules = [
                                ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high'],
                                ['key' => 'admin_users', 'label' => 'Admin Users', 'icon' => 'fa-user-shield'],
                                ['key' => 'customers', 'label' => 'Customers', 'icon' => 'fa-users'],
                                ['key' => 'products', 'label' => 'Products', 'icon' => 'fa-box-open'],
                                ['key' => 'orders', 'label' => 'Orders', 'icon' => 'fa-cart-shopping'],
                                ['key' => 'categories', 'label' => 'Categories', 'icon' => 'fa-tags'],
                                ['key' => 'brands', 'label' => 'Brands', 'icon' => 'fa-copyright'],
                                ['key' => 'coupons', 'label' => 'Coupons', 'icon' => 'fa-ticket'],
                                ['key' => 'sliders', 'label' => 'Sliders', 'icon' => 'fa-images'],
                                ['key' => 'shipping', 'label' => 'Shipping', 'icon' => 'fa-truck'],
                                ['key' => 'stock', 'label' => 'Stock', 'icon' => 'fa-warehouse'],
                                ['key' => 'reviews', 'label' => 'Reviews', 'icon' => 'fa-star'],
                                ['key' => 'return_orders', 'label' => 'Return Orders', 'icon' => 'fa-rotate-left'],
                                ['key' => 'reports', 'label' => 'Reports', 'icon' => 'fa-chart-bar'],
                                ['key' => 'settings', 'label' => 'Settings', 'icon' => 'fa-gear'],
                            ];
                        @endphp

                        <div class="row g-2">
                            @foreach ($modules as $module)
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="border rounded-2 px-3 py-2 d-flex align-items-center gap-2 bg-white">
                                        <input class="form-check-input access-checkbox mt-0 flex-shrink-0" type="checkbox"
                                            name="access[]" value="{{ $module['key'] }}" id="access_{{ $module['key'] }}"
                                            {{ in_array($module['key'], old('access', $adminUser->access ?? [])) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold mb-0 w-100"
                                            for="access_{{ $module['key'] }}" role="button">
                                            <i class="fas {{ $module['icon'] }} text-secondary me-1"></i>
                                            {{ $module['label'] }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary px-4">
                        <i class="fa-solid fa-arrow-left-long"></i> Back
                    </a>
                    <button type="submit" class="btn btn-dark px-4"> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        (function() {
            const selectAll = document.getElementById('selectAll');
            const boxes = document.querySelectorAll('.access-checkbox');

            function syncSelectAll() {
                const checked = [...boxes].filter(c => c.checked).length;
                selectAll.checked = checked === boxes.length;
                selectAll.indeterminate = checked > 0 && checked < boxes.length;
            }

            selectAll.addEventListener('change', function() {
                boxes.forEach(cb => cb.checked = this.checked);
            });

            boxes.forEach(cb => cb.addEventListener('change', syncSelectAll));
        })();
    </script>
@endsection
