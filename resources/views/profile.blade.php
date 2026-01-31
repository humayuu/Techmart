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
                            <li> <a href="#orders" data-bs-toggle="tab" class="nav-link">Orders</a></li>
                            <li><a href="#address" data-bs-toggle="tab" class="nav-link">Addresses</a></li>
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
                        <div class="tab-pane fade" id="orders">
                            <h4>Orders</h4>
                            <div class="table_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>May 10, 2018</td>
                                            <td><span class="success">Completed</span></td>
                                            <td>$25.00 for 1 item </td>
                                            <td><a href="cart.html" class="view">view</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>May 10, 2018</td>
                                            <td>Processing</td>
                                            <td>$17.00 for 1 item </td>
                                            <td><a href="cart.html" class="view">view</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="changer-password">
                            <h4>Change Password</h4>
                            <div class="table_page table-responsive">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    {{-- Add this to show all errors --}}
                                    @if ($errors->updatePassword->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->updatePassword->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="default-form-box mb-20">
                                        <label>Current Password</label>
                                        <input type="password" name="current_password">
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
                        <div class="tab-pane" id="address">
                            <p>The following addresses will be used on the checkout page by default.</p>
                            <h5 class="billing-address">Billing address</h5>
                            <a href="#" class="view">Edit</a>
                            <p class="mb-2"><strong>Michael M Hoskins</strong></p>
                            <address>
                                <span class="mb-1 d-inline-block"><strong>City:</strong> Seattle</span>,
                                <br>
                                <span class="mb-1 d-inline-block"><strong>State:</strong> Washington(WA)</span>,
                                <br>
                                <span class="mb-1 d-inline-block"><strong>ZIP:</strong> 98101</span>,
                                <br>
                                <span><strong>Country:</strong> USA</span>
                            </address>
                        </div>
                        <div class="tab-pane fade" id="account-details">
                            <h3>Account details </h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
                                        <form method="POST" action="{{ route('profile.update') }}">
                                            @csrf
                                            @method('patch')
                                            <div class="default-form-box mb-20">
                                                <label>Fullname</label>
                                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                                            </div>
                                            <div class="default-form-box mb-20">
                                                <label>Email</label>
                                                <input type="text" name="email" value="{{ Auth::user()->email }}">
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
    @if ($errors->updatePassword->any() || session('status') === 'password-updated')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tab = new bootstrap.Tab(document.querySelector('a[href="#changer-password"]'));
                tab.show();
            });
        </script>
    @endif

    @if ($errors->updateProfile->any() || session('status') === 'profile-updated')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tab = new bootstrap.Tab(document.querySelector('a[href="#account-details"]'));
                tab.show();
            });
        </script>
    @endif
@endsection
