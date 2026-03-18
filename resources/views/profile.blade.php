@extends('layout')
@section('main')
    <div class="account-dashboard pt-100px pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Order Info</a></li>
                            <li><a href="#account-details" data-bs-toggle="tab" class="nav-link">Account details</a></li>
                            <li><a href="#changer-password" data-bs-toggle="tab" class="nav-link">Change Password</a></li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <li>
                                    <a href="#" class="nav-link"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-12 col-md-9 col-lg-9">
                    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                        <div class="tab-pane fade show active" id="dashboard">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Shipping Amount</th>
                                        <th>Total </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($userOrders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge fs-6 bg-{{ $order->payment_method === 'cod' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($order->payment_method) }}
                                                </span>
                                            </td>
                                            <td>Rs.{{ number_format($order->shipping_amount, 2) }}</td>
                                            <td>Rs.{{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                @if ($order->status !== 'delivered')
                                                    <a href="{{ route('track.order', $order->id) }}"
                                                        class="bg-primary text-white p-1 m-1 rounded">Track
                                                        Order</a>
                                                @else
                                                    <span class="badge fs-6 bg-success">Delivered</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('order.show', $order->id) }}">Detail</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $userOrders->links() }}
                            </div>
                        </div>

                        {{-- Change Password Tab --}}
                        <div class="tab-pane fade" id="changer-password">
                            <h4>Change Password</h4>
                            <div class="table_page table-responsive">
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

                        {{-- Account Details Tab --}}
                        <div class="tab-pane fade" id="account-details">
                            <h3>Account details</h3>
                            <div class="login">
                                <div class="login_form_container">
                                    <div class="account_login_form">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->updatePassword->any() || session('status') === 'password-updated')
                const passwordTab = new bootstrap.Tab(document.querySelector('a[href="#changer-password"]'));
                passwordTab.show();
            @endif

            @if ($errors->updateProfile->any() || session('status') === 'profile-updated')
                const accountTab = new bootstrap.Tab(document.querySelector('a[href="#account-details"]'));
                accountTab.show();
            @endif
        });
    </script>
@endsection
