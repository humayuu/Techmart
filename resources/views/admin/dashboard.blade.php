@extends('admin.layout')

@section('skip_index_js')
@endsection

@section('page-title')
    Dashboard
@endsection

@section('main')
    @php
        $admin = auth('admin')->user();
    @endphp

    {{-- Catalog & people: compact cards, left accent + icon (no circles) --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-2 mb-2">
        <div class="col">
            <div class="card radius-10 mb-0 h-100 border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body py-3 px-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <i class="fa-solid fa-box-open fa-xl text-primary" aria-hidden="true"></i>
                        @if ($admin->hasAccess('products'))
                            <i class="fa-solid fa-arrow-up-right-from-square small text-muted opacity-75" aria-hidden="true"></i>
                        @endif
                    </div>
                    <p class="mb-1 mt-2 text-secondary small text-uppercase fw-semibold">Products</p>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalProducts) }}</h4>
                    @if ($admin->hasAccess('products'))
                        <a href="{{ route('product.index') }}" class="stretched-link text-decoration-none"><span class="visually-hidden">Products</span></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 mb-0 h-100 border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body py-3 px-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <i class="fa-solid fa-tags fa-xl text-info" aria-hidden="true"></i>
                        @if ($admin->hasAccess('brands'))
                            <i class="fa-solid fa-arrow-up-right-from-square small text-muted opacity-75" aria-hidden="true"></i>
                        @endif
                    </div>
                    <p class="mb-1 mt-2 text-secondary small text-uppercase fw-semibold">Brands</p>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalBrands) }}</h4>
                    @if ($admin->hasAccess('brands'))
                        <a href="{{ route('brand.index') }}" class="stretched-link text-decoration-none"><span class="visually-hidden">Brands</span></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 mb-0 h-100 border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body py-3 px-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <i class="fa-solid fa-folder-tree fa-xl text-success" aria-hidden="true"></i>
                        @if ($admin->hasAccess('categories'))
                            <i class="fa-solid fa-arrow-up-right-from-square small text-muted opacity-75" aria-hidden="true"></i>
                        @endif
                    </div>
                    <p class="mb-1 mt-2 text-secondary small text-uppercase fw-semibold">Categories</p>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalCategories) }}</h4>
                    @if ($admin->hasAccess('categories'))
                        <a href="{{ route('category.index') }}" class="stretched-link text-decoration-none"><span class="visually-hidden">Categories</span></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 mb-0 h-100 border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body py-3 px-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <i class="fa-solid fa-users fa-xl text-warning" aria-hidden="true"></i>
                        @if ($admin->hasAccess('customers'))
                            <i class="fa-solid fa-arrow-up-right-from-square small text-muted opacity-75" aria-hidden="true"></i>
                        @endif
                    </div>
                    <p class="mb-1 mt-2 text-secondary small text-uppercase fw-semibold">Users</p>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h4>
                    @if ($admin->hasAccess('customers'))
                        <a href="{{ route('customer.index') }}" class="stretched-link text-decoration-none"><span class="visually-hidden">Users</span></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 mb-0 h-100 border-0 shadow-sm border-start border-4 border-secondary">
                <div class="card-body py-3 px-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <i class="fa-solid fa-user-shield fa-xl text-secondary" aria-hidden="true"></i>
                        @if ($admin->hasAccess('admin_users'))
                            <i class="fa-solid fa-arrow-up-right-from-square small text-muted opacity-75" aria-hidden="true"></i>
                        @endif
                    </div>
                    <p class="mb-1 mt-2 text-secondary small text-uppercase fw-semibold">Admin users</p>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalAdminUsers) }}</h4>
                    @if ($admin->hasAccess('admin_users'))
                        <a href="{{ route('admin.user') }}" class="stretched-link text-decoration-none"><span class="visually-hidden">Admin users</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Order metrics in one scannable row --}}
    <div class="card radius-10 border-0 shadow-sm border-start border-4 border-dark mb-3">
        <div class="card-body py-3 px-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-cart-shopping fa-lg text-dark" aria-hidden="true"></i>
                    <span class="fw-semibold">Order activity</span>
                    <span class="text-muted small d-none d-sm-inline">All-time, year, month, and last 24 hours</span>
                </div>
                @if ($admin->hasAccess('orders'))
                    <a href="{{ route('pending.order') }}" class="btn btn-sm btn-outline-dark">
                        <i class="fa-solid fa-list me-1" aria-hidden="true"></i>
                        All orders
                    </a>
                @endif
            </div>
            <div class="row row-cols-2 row-cols-md-4 g-2">
                <div class="col">
                    <div class="rounded-3 bg-light p-3 h-100 text-center">
                        <i class="fa-solid fa-infinity text-muted small d-block mb-1" aria-hidden="true"></i>
                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.65rem;">All time</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-3 bg-light p-3 h-100 text-center">
                        <i class="fa-solid fa-calendar text-muted small d-block mb-1" aria-hidden="true"></i>
                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.65rem;">Year {{ now()->format('Y') }}</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($ordersThisYear) }}</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-3 bg-light p-3 h-100 text-center">
                        <i class="fa-solid fa-calendar-day text-muted small d-block mb-1" aria-hidden="true"></i>
                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.65rem;">This month</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($ordersThisMonth) }}</h4>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-3 bg-light p-3 h-100 text-center">
                        <i class="fa-solid fa-bolt text-danger small d-block mb-1" aria-hidden="true"></i>
                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.65rem;">Last 24 hours</small>
                        <h4 class="mb-0 fw-bold">{{ number_format($ordersLast24Hours) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-12">
            <div class="card radius-10 w-100 border-0 shadow-sm">
                <div class="card-body py-3 px-3">
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-3 pb-2 border-bottom">
                        <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2 flex-wrap">
                            <i class="fa-solid fa-receipt text-primary" aria-hidden="true"></i>
                            Recent orders
                            <span class="badge bg-light text-dark fw-normal border">
                                <i class="fa-solid fa-list-ul me-1" aria-hidden="true"></i>
                                Latest 10
                            </span>
                        </h6>
                        <span class="text-muted small ms-sm-2 d-none d-md-inline">Newest first</span>
                        @if ($admin->hasAccess('orders'))
                            <a href="{{ route('pending.order') }}" class="btn btn-sm btn-primary ms-md-auto">
                                <i class="fa-solid fa-arrow-right me-1" aria-hidden="true"></i>
                                View all orders
                            </a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-secondary text-uppercase">
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-hashtag me-1 text-muted" aria-hidden="true"></i>Order
                                    </th>
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-user me-1 text-muted" aria-hidden="true"></i>Customer
                                    </th>
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-cube me-1 text-muted" aria-hidden="true"></i>Items
                                    </th>
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-coins me-1 text-muted" aria-hidden="true"></i>Total
                                    </th>
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-signal me-1 text-muted" aria-hidden="true"></i>Status
                                    </th>
                                    <th scope="col" class="fw-semibold">
                                        <i class="fa-solid fa-calendar-day me-1 text-muted" aria-hidden="true"></i>Date
                                    </th>
                                    <th scope="col" class="text-end fw-semibold">
                                        <i class="fa-solid fa-gear me-1 text-muted" aria-hidden="true"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                    @php
                                        $line = $order->orderProducts->first();
                                        $statusClass = match ($order->status) {
                                            'pending' => 'bg-warning text-dark',
                                            'processing' => 'bg-info text-dark',
                                            'shipped' => 'bg-primary',
                                            'delivered' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            'refunded' => 'bg-secondary',
                                            default => 'bg-secondary',
                                        };
                                        $statusIcon = match ($order->status) {
                                            'pending' => 'fa-hourglass-half',
                                            'processing' => 'fa-gears',
                                            'shipped' => 'fa-truck-fast',
                                            'delivered' => 'fa-circle-check',
                                            'cancelled' => 'fa-circle-xmark',
                                            'refunded' => 'fa-rotate-left',
                                            default => 'fa-circle-question',
                                        };
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">
                                                <i class="fa-solid fa-receipt text-muted me-1 small" aria-hidden="true"></i>#{{ $order->id }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($order->user)
                                                <div class="d-flex align-items-start gap-2">
                                                    <span class="text-muted mt-1"><i class="fa-solid fa-user-circle" aria-hidden="true"></i></span>
                                                    <div>
                                                        <div>{{ $order->user->name }}</div>
                                                        <small class="text-muted">
                                                            <i class="fa-regular fa-envelope me-1" aria-hidden="true"></i>{{ $order->user->email }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted"><i class="fa-solid fa-user-slash me-1" aria-hidden="true"></i>—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($line)
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($line->product_image)
                                                        <div class="product-box border rounded overflow-hidden flex-shrink-0" style="width:40px;height:40px;">
                                                            <img src="{{ asset('images/products/thumbnail/' . $line->product_image) }}"
                                                                alt="" class="w-100 h-100 object-fit-cover" />
                                                        </div>
                                                    @else
                                                        <span class="d-inline-flex align-items-center justify-content-center border rounded bg-light text-muted flex-shrink-0"
                                                            style="width:40px;height:40px;">
                                                            <i class="fa-solid fa-image" aria-hidden="true"></i>
                                                        </span>
                                                    @endif
                                                    <div>
                                                        <div class="text-truncate" style="max-width: 220px;" title="{{ $line->product_name }}">
                                                            {{ $line->product_name }}
                                                        </div>
                                                        @if ($order->order_products_count > 1)
                                                            <small class="text-muted">
                                                                <i class="fa-solid fa-layer-group me-1" aria-hidden="true"></i>
                                                                + {{ $order->order_products_count - 1 }} more
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                <i class="fa-solid fa-coins me-1 small opacity-75" aria-hidden="true"></i>RS.{{ number_format($order->total_amount, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge {{ $statusClass }}">
                                                <i class="fa-solid {{ $statusIcon }} me-1" aria-hidden="true"></i>{{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <i class="fa-regular fa-calendar me-1 text-muted" aria-hidden="true"></i>{{ $order->created_at->format('M d, Y') }}
                                            </div>
                                            <small class="text-muted">
                                                <i class="fa-regular fa-clock me-1" aria-hidden="true"></i>{{ $order->created_at->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td class="text-end">
                                            @if ($admin->hasAccess('orders'))
                                                <a href="{{ route('orders.detail', $order->id) }}" class="btn btn-sm btn-dark"
                                                    data-bs-toggle="tooltip" title="View order">
                                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                                    <span class="visually-hidden">View order</span>
                                                </a>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <i class="fa-solid fa-cart-flatbed fa-3x mb-3 d-block opacity-25" aria-hidden="true"></i>
                                            <span class="d-block fw-semibold">No orders yet</span>
                                            <small>When customers place orders, they will show up here.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
