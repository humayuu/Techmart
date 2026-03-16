<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('backend/assets/images/favicon-32x32.png') }}" type="image/png" />

    {{-- Plugins & CSS --}}
    <link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/pace.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />

    <title>TechMart Admin Dashboard</title>
</head>

<body>

    @php
        $admin = auth('admin')->user();
        $unreadCount = $admin->unreadNotifications->count();
    @endphp

    <div class="wrapper">

        {{-- ===================== TOP HEADER ===================== --}}
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">

                <div class="mobile-toggle-icon fs-3">
                    <i class="bi bi-list"></i>
                </div>

                {{-- Notification Bell --}}
                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center">

                        <li class="nav-item search-toggle-icon">
                            <a class="nav-link" href="#"><i class="bi bi-search"></i></a>
                        </li>

                        <li class="nav-item dropdown dropdown-large">
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
                                    @forelse($admin->unreadNotifications as $notification)
                                        <li class="notification-item" id="notif-{{ $notification->id }}">
                                            <a class="dropdown-item" href="#"
                                                data-redirect="{{ $admin->notificationRedirectUrl($notification->data) }}"
                                                data-id="{{ $notification->id }}" onclick="markRead(this, event)">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="notification-box bg-light-primary text-primary">
                                                        <i class="bi bi-basket2-fill"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fw-semibold">
                                                            {{ $notification->data['message'] }}</p>
                                                        <small class="text-muted">
                                                            Rs.
                                                            {{ number_format($notification->data['total_amount']) }}
                                                            &bull; {{ $notification->created_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li id="no-notifications">
                                            <span class="dropdown-item text-muted text-center py-3">
                                                <i class="bi bi-bell-slash d-block fs-4 mb-1"></i>
                                                No new notifications
                                            </span>
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
                        </li>

                    </ul>
                </div>

                {{-- User Profile Dropdown --}}
                <div class="dropdown dropdown-user-setting">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-3">
                            <img src="{{ $admin->profile_image ? asset('images/profile_image/' . $admin->profile_image) : asset('default-avatar.png') }}"
                                class="user-img" alt="Profile" />
                            <div class="d-none d-sm-block">
                                <p class="user-name mb-0">{{ Str::title($admin->name) }}</p>
                                @if ($admin->role === 'admin')
                                    <small class="mb-0 dropdown-user-designation fw-bold">
                                        {{ Str::title($admin->role) }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('admin.profile.detail') }}" class="dropdown-item">
                                <i class="bi bi-person-fill"></i><span class="ms-3">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.change.password') }}" class="dropdown-item">
                                <i class="bi bi-gear-fill"></i><span class="ms-3">Change Password</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                <i class="bi bi-lock-fill"></i><span class="ms-3">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        {{-- ===================== END TOP HEADER ===================== --}}


        {{-- ===================== SIDEBAR ===================== --}}
        <aside class="sidebar-wrapper">
            <div class="sidebar-header">
                <div></div>
                <div>
                    <h4 class="logo-text fs-2 m-4"><span class="text-dark">Tech</span>Mart</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class="bi bi-list"></i></div>
            </div>

            <div class="overflow-auto" style="height: calc(100vh - 80px);">
                <ul class="metismenu" id="menu">

                    @if ($admin->hasAccess('dashboard'))
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <div class="parent-icon"><i class="fas fa-home"></i></div>
                                <div class="menu-title">Dashboard</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('customers'))
                        <li>
                            <a href="{{ route('customer.index') }}">
                                <div class="parent-icon"><i class="fas fa-users"></i></div>
                                <div class="menu-title">Customers</div>
                            </a>
                        </li>
                    @endif

                    <li class="menu-label">Main Menu</li>

                    @if ($admin->hasAccess('brands'))
                        <li>
                            <a href="{{ route('brand.index') }}">
                                <div class="parent-icon"><i class="fas fa-tag"></i></div>
                                <div class="menu-title">Brands</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('categories'))
                        <li>
                            <a href="{{ route('category.index') }}">
                                <div class="parent-icon"><i class="fas fa-th-large"></i></div>
                                <div class="menu-title">Categories</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('products'))
                        <li>
                            <a href="{{ route('product.index') }}">
                                <div class="parent-icon"><i class="fas fa-shopping-cart"></i></div>
                                <div class="menu-title">Products</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('sliders'))
                        <li>
                            <a href="{{ route('slider.index') }}">
                                <div class="parent-icon"><i class="fas fa-images"></i></div>
                                <div class="menu-title">Sliders</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('admin_users'))
                        <li>
                            <a href="{{ route('admin.user') }}">
                                <div class="parent-icon"><i class="fas fa-user"></i></div>
                                <div class="menu-title">Admin Users</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('coupons'))
                        <li>
                            <a href="{{ route('coupon.index') }}">
                                <div class="parent-icon"><i class="fas fa-ticket-alt"></i></div>
                                <div class="menu-title">Coupons</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('shipping'))
                        <li>
                            <a href="javascript:;">
                                <div class="parent-icon"><i class="fas fa-shipping-fast"></i></div>
                                <div class="menu-title">Shipping Area</div>
                            </a>
                            <ul>
                                <li><a href="{{ route('province.index') }}"><i class="far fa-circle"></i>
                                        Provinces</a></li>
                                <li><a href="{{ route('city.index') }}"><i class="far fa-circle"></i> Cities</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($admin->hasAccess('orders'))
                        <li>
                            <a href="javascript:;">
                                <div class="parent-icon"><i class="fas fa-shopping-bag"></i></div>
                                <div class="menu-title">Orders</div>
                            </a>
                            <ul>
                                <li><a href="{{ route('pending.order') }}"><i class="far fa-circle"></i> Pending</a>
                                </li>
                                <li><a href="{{ route('processing.order') }}"><i class="far fa-circle"></i>
                                        Processing</a></li>
                                <li><a href="{{ route('shipped.order') }}"><i class="far fa-circle"></i> Shipped</a>
                                </li>
                                <li><a href="{{ route('delivered') }}"><i class="far fa-circle"></i> Delivered</a>
                                </li>
                                <li><a href="{{ route('cancel.order') }}"><i class="far fa-circle"></i> Cancelled</a>
                                </li>
                                <li><a href="{{ route('refunded') }}"><i class="far fa-circle"></i> Refunded</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($admin->hasAccess('stock'))
                        <li>
                            <a href="{{ route('stock.index') }}">
                                <div class="parent-icon"><i class="fas fa-boxes"></i></div>
                                <div class="menu-title">Stock</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('return_orders'))
                        <li>
                            <a href="javascript:;">
                                <div class="parent-icon"><i class="fas fa-undo-alt"></i></div>
                                <div class="menu-title">Return Orders</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('reviews'))
                        <li>
                            <a href="javascript:;">
                                <div class="parent-icon"><i class="fas fa-star"></i></div>
                                <div class="menu-title">Reviews</div>
                            </a>
                        </li>
                    @endif

                    @if ($admin->hasAccess('settings'))
                        <li>
                            <a href="javascript:;">
                                <div class="parent-icon"><i class="fas fa-cog"></i></div>
                                <div class="menu-title">Settings</div>
                            </a>
                            <ul>
                                <li><a href="{{ route('settings.index') }}"><i class="far fa-circle"></i> Site
                                        Settings</a></li>
                                @if ($admin->hasAccess('seo_settings'))
                                    <li><a href="{{ route('seo.index') }}"><i class="far fa-circle"></i> Seo
                                            Settings</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                </ul>
            </div>
        </aside>
        {{-- ===================== END SIDEBAR ===================== --}}


        {{-- ===================== MAIN CONTENT ===================== --}}
        <main class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item active fs-2 text-dark" aria-current="page">
                                @yield('page-title')
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            @yield('main')
        </main>
        {{-- ===================== END MAIN CONTENT ===================== --}}


        <footer class="footer">
            <div class="footer-text">Copyright &copy; 2026. All rights reserved.</div>
        </footer>

    </div>{{-- end wrapper --}}


    {{-- ===================== SCRIPTS ===================== --}}
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/js/index.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

    {{-- ===================== NOTIFICATION SCRIPTS ===================== --}}
    <script>
        function markRead(element, event) {
            event.preventDefault();
            const notificationId = element.dataset.id;
            const redirectUrl = element.dataset.redirect;

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
                        document.getElementById(`notif-${notificationId}`)?.remove();
                        updateBadge(-1);
                        checkEmpty();
                    }
                    window.location.href = redirectUrl;

                })
                .catch(() => {
                    window.location.href = redirectUrl;
                });
        }

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
                    .then(r => {
                        if (!r.ok) throw new Error('Server error: ' + r.status);
                        return r.json();
                    })
                    .then(data => {
                        if (data.success) {
                            document.getElementById('notifications-wrapper').innerHTML = `
                            <li id="no-notifications">
                                <span class="dropdown-item text-muted text-center py-3">
                                    <i class="bi bi-bell-slash d-block fs-4 mb-1"></i>
                                    No new notifications
                                </span>
                            </li>`;

                            const badge = document.querySelector('.notify-badge');
                            if (badge) badge.style.display = 'none';

                            markAllBtn.closest('li').style.display = 'none';
                            markAllBtn.closest('li').previousElementSibling.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        toastr.error('Something went wrong. Please try again.');
                    });
            });
        }

        function updateBadge(change) {
            const badge = document.querySelector('.notify-badge');
            if (!badge) return;
            const newCount = (parseInt(badge.textContent) || 0) + change;
            badge.style.display = newCount <= 0 ? 'none' : 'inline-block';
            if (newCount > 0) badge.textContent = newCount;
        }

        function checkEmpty() {
            if (document.querySelectorAll('.notification-item').length === 0) {
                document.getElementById('notifications-wrapper').innerHTML = `
                    <li id="no-notifications">
                        <span class="dropdown-item text-muted text-center py-3">
                            <i class="bi bi-bell-slash d-block fs-4 mb-1"></i>
                            No new notifications
                        </span>
                    </li>`;

                const btn = document.getElementById('mark-all-btn');
                if (btn) {
                    btn.closest('li').style.display = 'none';
                    btn.closest('li').previousElementSibling.style.display = 'none';
                }
            }
        }
    </script>

    {{-- ===================== TOASTR FLASH MESSAGES ===================== --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-left",
            timeOut: "3500"
        };

        @if (Session::has('message'))
            const alertType = "{{ Session::get('alert-type', 'info') }}";
            const alertMsg = "{{ Session::get('message') }}";
            if (toastr[alertType]) toastr[alertType](alertMsg);
        @endif
    </script>

    {{-- ===================== DATATABLES ===================== --}}
    <script>
        function initDataTable(tableId, url, columns) {
            if (!$('#' + tableId).length) return;
            $('#' + tableId).DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: url
                },
                columns: columns
            });
        }

        function orderColumns(extraActionClass = '') {
            return [{
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
                },
            ];
        }

        $(document).ready(function() {

            // --- Categories ---
            initDataTable('categoryTable', "{{ route('category.index') }}", [{
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
                },
            ]);

            // --- Brands ---
            initDataTable('brandTable', "{{ route('brand.index') }}", [{
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
                },
            ]);

            // --- Sliders ---
            initDataTable('sliderTable', "{{ route('slider.index') }}", [{
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
                },
            ]);

            // --- Products ---
            initDataTable('productTable', "{{ route('product.index') }}", [{
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
                },
            ]);

            // --- Customers ---
            initDataTable('userTable', "{{ route('customer.index') }}", [{
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
                },
            ]);

            // --- Provinces ---
            initDataTable('provinceTable', "{{ route('province.index') }}", [{
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
                },
            ]);

            // --- Cities ---
            initDataTable('cityTable', "{{ route('city.index') }}", [{
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
                },
            ]);

            // --- Coupons ---
            initDataTable('couponTable', "{{ route('coupon.index') }}", [{
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
                },
            ]);

            // --- Orders (all 6 share the same columns via orderColumns()) ---
            initDataTable('pendingOrder', "{{ route('pending.order') }}", orderColumns());
            initDataTable('processingOrder', "{{ route('processing.order') }}", orderColumns());
            initDataTable('shippedOrder', "{{ route('shipped.order') }}", orderColumns());
            initDataTable('delivered', "{{ route('delivered') }}", orderColumns());
            initDataTable('cancelOrder', "{{ route('cancel.order') }}", orderColumns());
            initDataTable('refund', "{{ route('refunded') }}", orderColumns());

            // --- Stock ---
            initDataTable('stock', "{{ route('stock.index') }}", [{
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
                },
            ]);

            // --- Admin Users ---
            initDataTable('adminUser', "{{ route('admin.user') }}", [{
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
                },
            ]);

        });
    </script>

    {{-- Child views can push their own scripts here --}}
    @stack('scripts')

</body>

</html>
