@extends('admin.layout')

@section('main')
    <div class="container-fluid">

        <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-4 mb-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-receipt me-2"></i>
                    Return #{{ $returnOrder->return_number }} — Order #{{ $returnOrder->order->id }}
                </h5>
                @if ($returnOrder->status === 'pending')
                    <span class="badge bg-warning text-dark fs-5 px-3 py-2">Pending</span>
                @else
                    <span class="badge bg-success fs-5 px-3 py-2">Refunded</span>
                @endif
            </div>

            <div class="card-body">

                {{-- Customer & Return Info --}}
                <div class="row mb-4">

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Customer Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Name</span>
                                <span class="fw-semibold">{{ $returnOrder->user->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Email</span>
                                <span>{{ $returnOrder->user->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Phone</span>
                                <span>{{ $returnOrder->user->phone ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>City</span>
                                <span>{{ $returnOrder->order->city }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Province</span>
                                <span>{{ $returnOrder->order->province }}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-semibold">Address</span>
                                <div class="text-muted">{{ $returnOrder->order->address }}</div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Return Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Return Number</span>
                                <span class="fw-semibold">{{ $returnOrder->return_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Reason</span>
                                <span>{{ ucwords(str_replace('_', ' ', $returnOrder->reason)) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Refund Amount</span>
                                <span class="fw-semibold text-success">
                                    Rs.{{ number_format($returnOrder->refund_amount, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Submitted On</span>
                                <span>{{ $returnOrder->created_at->format('d M Y, h:i A') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Refunded At</span>
                                <span>
                                    {{ $returnOrder->refunded_at ? $returnOrder->refunded_at->format('d M Y, h:i A') : '—' }}
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-semibold">Description</span>
                                <div class="text-muted">{{ $returnOrder->description ?? '—' }}</div>
                            </li>
                        </ul>
                    </div>

                </div>

                {{-- Order Items --}}
                <h6 class="fw-bold mb-3">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returnOrder->order->orderProducts as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-semibold">{{ $item->product->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rs.{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="fw-semibold">
                                        Rs.{{ number_format($item->quantity * $item->unit_price, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Order Totals --}}
                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>Rs.{{ number_format($returnOrder->order->subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping</span>
                                <span>Rs.{{ number_format($returnOrder->order->shipping_amount, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Discount</span>
                                <span class="text-danger">
                                    - Rs.{{ number_format($returnOrder->order->discount_amount, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-success">
                                    Rs.{{ number_format($returnOrder->order->total_amount, 2) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="mt-4">
                    <h6 class="fw-bold">Notes</h6>
                    <div class="p-3 bg-light rounded">
                        {{ $returnOrder->order->notes ?? 'No notes added.' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
