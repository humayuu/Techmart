@extends('layout')
@section('main')
    <!-- account area start -->
    <div class="account-dashboard pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Dashboard</a>
                            </li>
                            <li><a href="#account-details" data-bs-toggle="tab" class="nav-link">Account
                                    details</a>
                            </li>
                            <li><a href="#changer-password" data-bs-toggle="tab" class="nav-link">Change Password</a></li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <li>
                                    <a href="#" class="nav-link"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        logout
                                    </a>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                        <div class="tab-pane fade show active" id="dashboard">
                            <h4>Dashboard </h4>
                            <p>From your account dashboard. you can easily check &amp; view your <a href="#">recent
                                    orders</a>, manage your <a href="#">shipping and billing addresses</a>
                                and <a href="#">Edit your password and account details.</a></p>
                        </div>
                        <div class="tab-pane fade" id="changer-password">
                            <h4>Change Password</h4>
                            <div class="table_page table-responsive">
                                {{-- Success message for password change --}}
                                @if (session('status') === 'password-updated')
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Password updated Successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')
                                    <div class="default-form-box mb-20">
                                        <label>Current Password</label>
                                        <input type="password" class="@error('current_password') is-invalid @enderror"
                                            name="current_password">
                                        @error('current_password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="default-form-box mb-20">
                                        <label>New Password</label>
                                        <input type="password" name="password">
                                        @error('password', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="default-form-box mb-20">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation">
                                        @error('password_confirmation', 'updatePassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="save_button mt-3">
                                        <button class="btn" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-details">
                            <h3>Account details </h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        {{-- Success message for profile update --}}
                                        @if (session('status') === 'profile-updated')
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Profile updated Successfully!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('patch')
                                            <div class="default-form-box mb-20">
                                                <label>Fullname</label>
                                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Email</label>
                                                <input type="text" name="email" value="{{ Auth::user()->email }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Phone</label>
                                                <input type="text" name="phone" value="{{ Auth::user()->phone }}">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="save_button mt-3">
                                                <button class="btn" type="submit">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- account area start -->
    {{-- Auto-open correct tab on validation errors or success --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for password change errors or success
            @if ($errors->updatePassword->any() || session('status') === 'password-updated')
                const passwordTab = new bootstrap.Tab(document.querySelector('a[href="#changer-password"]'));
                passwordTab.show();
            @endif

            // Check for profile update errors or success
            @if ($errors->default->any() || session('status') === 'profile-updated')
                const accountTab = new bootstrap.Tab(document.querySelector('a[href="#account-details"]'));
                accountTab.show();
            @endif
        });
    </script>
@endsection
