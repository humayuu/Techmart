<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('backend/assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <!-- loader-->
    <link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
    {{-- font-awesome icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TechMart Admin Dashboard</title>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">

        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-icon fs-3">
                    <i class="bi bi-list"></i>
                </div>
                <form class="searchbar">
                    <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
                        <i class="bi bi-search"></i>
                    </div>
                    <input class="form-control" type="text" placeholder="Type here to search" />
                    <div class="position-absolute top-50 translate-middle-y search-close-icon">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </form>

                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item search-toggle-icon">
                            <a class="nav-link" href="#">
                                <div class="">
                                    <i class="bi bi-search"></i>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown dropdown-large">
                            @php
                                $unreadCount = auth('admin')->user()->unreadNotifications->count();
                            @endphp

                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="notifications">
                                    @if ($unreadCount > 0)
                                        <span class="notify-badge">{{ $unreadCount }}</span>
                                    @endif
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" id="notification-dropdown">

                                <li class="px-3 py-2">
                                    <h6 class="mb-0">Notifications</h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <div id="notifications-wrapper">
                                    @forelse(auth('admin')->user()->unreadNotifications as $notification)
                                        <li class="notification-item" id="notif-{{ $notification->id }}">
                                            <a class="dropdown-item"
                                                href="{{ route('orders.detail', $notification->data['order_id']) }}"
                                                onclick="markRead('{{ $notification->id }}', event)">
                                                <p class="mb-0">{{ $notification->data['message'] }}</p>
                                                <small class="text-muted">
                                                    Rs. {{ $notification->data['total_amount'] }}
                                                    &bull; {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </a>
                                        </li>
                                    @empty
                                        <li id="no-notifications">
                                            <span class="dropdown-item text-muted">No new notifications</span>
                                        </li>
                                    @endforelse
                                </div>

                                @if ($unreadCount > 0)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a href="#" id="mark-all-btn"
                                            class="dropdown-item text-center text-primary">
                                            Mark all as read
                                        </a>
                                    </li>
                                @endif

                            </ul>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2 border-bottom m-2">
                                    <h5 class="h5 mb-0">Notifications</h5>
                                </div>
                                <div class="header-notifications-list p-2">
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="notification-box bg-light-primary text-primary">
                                                <i class="bi bi-basket2-fill"></i>
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-0 dropdown-msg-user">
                                                    New Orders
                                                    <span class="msg-time float-end text-secondary">1 m</span>
                                                </h6>
                                                <small
                                                    class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">
                                                    You have recived new orders
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <!-- END notification dropdown -->

                    </ul>
                </div>
                @php
                    $user = Auth::guard('admin')->user();
                @endphp
                <div class="dropdown dropdown-user-setting">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-3">
                            @if (empty($user->profile_image))
                                <img src="{{ asset('default-avatar.png') }}" class="user-img" alt="" />
                            @else
                                <img src="{{ asset('images/profile_image/' . $user->profile_image) }}" class="user-img"
                                    alt="" />
                            @endif
                            <div class="d-none d-sm-block ">
                                <p class="user-name mb-0">{{ Str::title($user->name) }}</p>
                                <small class="mb-0 dropdown-user-designation fw-bold"></small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('admin.profile.detail') }}" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.change.password') }}" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-gear-fill"></i></div>
                                    <div class="ms-3"><span>Change Password</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-lock-fill"></i></div>
                                    <div class="ms-3"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper">
            <div class="sidebar-header">
                <div></div>
                <div>
                    <h4 class="logo-text fs-2 m-4"><span class="text-dark">Tech</span>Mart</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class="bi bi-list"></i></div>
            </div>
            <!--navigation-->
            <div class="overflow-auto" style="height: calc(100vh - 80px);">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="parent-icon"><i class="fas fa-home"></i></div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('customer.index') }}">
                            <div class="parent-icon"><i class="fas fa-users"></i></div>
                            <div class="menu-title">Customer</div>
                        </a>
                    </li>

                    <li class="menu-label">Main Menu</li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-tag"></i></div>
                            <div class="menu-title">Manage Brands</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('brand.index') }}"><i class="far fa-circle"></i>All Brands</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-th-large"></i></div>
                            <div class="menu-title">Manage Categories</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('category.index') }}"><i class="far fa-circle"></i>All
                                    Categories</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-shopping-cart"></i></div>
                            <div class="menu-title">Manage Products</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('product.index') }}"><i class="far fa-circle"></i>All Products</a>
                            </li>
                            <li><a href="{{ route('product.create') }}"><i class="far fa-circle"></i>Add Products</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-images"></i></div>
                            <div class="menu-title">Manage Sliders</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('slider.index') }}"><i class="far fa-circle"></i>All Sliders</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-user"></i></div>
                            <div class="menu-title">Manage Admin Users</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.user') }}"><i class="far fa-circle"></i>All Admin Users</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-ticket-alt"></i></div>
                            <div class="menu-title">Manage Coupons</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('coupon.index') }}"><i class="far fa-circle"></i>All Coupons</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-shipping-fast"></i></div>
                            <div class="menu-title">Shipping Area</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('province.index') }}"><i class="far fa-circle"></i>All Province</a>
                            </li>
                            <li><a href="{{ route('city.index') }}"><i class="far fa-circle"></i>All Cities</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-shopping-bag"></i></div>
                            <div class="menu-title">Manage Orders</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('pending.order') }}"><i class="far fa-circle"></i>Pending </a></li>
                            <li><a href="{{ route('processing.order') }}"><i class="far fa-circle"></i>Processing</a>
                            </li>
                            <li><a href="{{ route('shipped.order') }}"><i class="far fa-circle"></i>Shipped</a></li>
                            <li><a href="{{ route('delivered') }}"><i class="far fa-circle"></i>Delivered</a>
                            </li>
                            <li><a href="{{ route('cancel.order') }}"><i class="far fa-circle"></i>Cancelled</a></li>
                            <li><a href="{{ route('refunded') }}"><i class="far fa-circle"></i>refunded</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-boxes"></i></div>
                            <div class="menu-title">Manage Stock</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('stock.index') }}"><i class="far fa-circle"></i>All Stock</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-undo-alt"></i></div>
                            <div class="menu-title">Return Orders</div>
                        </a>
                        <ul>
                            <li><a href="#"><i class="far fa-circle"></i>All Return Orders</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-star"></i></div>
                            <div class="menu-title">Manage Reviews</div>
                        </a>
                        <ul>
                            <li><a href="#"><i class="far fa-circle"></i>All Reviews</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-cog"></i></div>
                            <div class="menu-title">Manage Settings</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('settings.index') }}"><i class="far fa-circle"></i>Site
                                    Settings</a></li>
                            <li><a href="#"><i class="far fa-circle"></i>Seo Settings</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </aside>
        <!--end sidebar -->

        <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item active fs-2 text-dark" aria-current="page">@yield('page-title')
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            @yield('main')
        </main>

        <!--start footer-->
        <footer class="footer">
            <div class="footer-text">Copyright © 2026. All right reserved.</div>
        </footer>
        <!--end footer-->

    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/js/index.js') }}"></script>

    <!-- Toaster JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    {{-- Sweet Alert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Data table CDN --}}
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
    <script>
        // Mark single notification as read
        function markRead(notificationId, event) {
            event.preventDefault();
            const link = event.currentTarget;

            fetch(`/admin/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Remove this item from dropdown
                        document.getElementById(`notif-${notificationId}`)?.remove();

                        // Update badge
                        updateBadge(-1);

                        // Check if empty
                        checkEmpty();

                        // Navigate to order page
                        window.location.href = link.href;
                    }
                });
        }

        // Mark all as read
        const markAllBtn = document.getElementById('mark-all-btn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();

                fetch('/admin/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            // Clear all items
                            document.getElementById('notifications-wrapper').innerHTML =
                                `<li id="no-notifications">
                            <span class="dropdown-item text-muted">No new notifications</span>
                        </li>`;

                            // Hide badge
                            const badge = document.querySelector('.notify-badge');
                            if (badge) badge.style.display = 'none';

                            // Hide button
                            markAllBtn.parentElement.style.display = 'none';
                        }
                    });
            });
        }

        // Update badge number
        function updateBadge(change) {
            const badge = document.querySelector('.notify-badge');
            if (!badge) return;
            const newCount = (parseInt(badge.textContent) || 0) + change;
            if (newCount <= 0) {
                badge.style.display = 'none';
            } else {
                badge.textContent = newCount;
            }
        }

        // Show empty message if no notifications left
        function checkEmpty() {
            const items = document.querySelectorAll('.notification-item');
            if (items.length === 0) {
                document.getElementById('notifications-wrapper').innerHTML =
                    `<li id="no-notifications">
                    <span class="dropdown-item text-muted">No new notifications</span>
                </li>`;
                const btn = document.getElementById('mark-all-btn');
                if (btn) btn.parentElement.style.display = 'none';
            }
        }
    </script>

    <!-- Toastr Notification Script -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "timeOut": "3500"
        };

        @if (Session::has('message'))
            let type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif

        $(document).ready(function() {

            $('#categoryTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('category.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'category_slug',
                        name: 'category_slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#brandTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('brand.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name'
                    },
                    {
                        data: 'brand_description',
                        name: 'brand_description'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#sliderTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('slider.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#productTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('product.index') }}"
                },
                columns: [{
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#userTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('customer.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'last_seen',
                        name: 'last_seen'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            $('#provinceTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('province.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            $('#cityTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('city.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'province_id',
                        name: 'province_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#couponTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('coupon.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'coupon_name',
                        name: 'coupon_name'
                    },
                    {
                        data: 'coupon_discount',
                        name: 'coupon_discount'
                    },
                    {
                        data: 'valid_until',
                        name: 'valid_until'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#pendingOrder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('pending.order') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#processingOrder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('processing.order') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#shippedOrder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('shipped.order') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });
            $('#delivered').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('delivered') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#cancelOrder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('cancel.order') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#refund').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('refunded') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        className: 'text-center'
                    },
                    {
                        data: 'customer',
                        name: 'customer',
                        className: 'text-center'
                    },
                    {
                        data: 'city',
                        name: 'city',
                        className: 'text-center'
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#stock').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('stock.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                        className: 'text-center'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className: 'text-center'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'stock',
                        name: 'stock',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

            $('#adminUser').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin.user') }}"
                },
                columns: [{
                        data: 'image',
                        name: 'image',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center action-col'
                    }

                ]

            });

        });
    </script>

</body>

</html>
