@extends('admin.layout')

@section('main')
    <div class="container-fluid">

        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-4 mb-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <div class="card shadow-sm border-0">

            <!-- Header -->
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-receipt me-2"></i> Order #{{ $order->id }}
                </h5>

                <span class="badge bg-success fs-5 px-3 py-2">
                    {{ $order->status }}
                </span>
            </div>


            <div class="card-body">

                <!-- Customer Info -->
                <div class="row mb-4">

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Customer Info</h6>

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Name</span>
                                <span class="fw-semibold">{{ $order->user->name }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Province</span>
                                <span>{{ $order->province }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>City</span>
                                <span>{{ $order->city }}</span>
                            </li>

                            <li class="list-group-item">
                                <span class="fw-semibold">Address</span>
                                <div class="text-muted">{{ $order->address }}</div>
                            </li>

                        </ul>
                    </div>


                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Payment Info</h6>

                        <ul class="list-group">

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Payment Status</span>
                                <span class="badge bg-warning text-dark fs-6 px-4">
                                    {{ $order->payment_status ?? 'Pending' }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Payment Method</span>
                                <span>{{ $order->payment_method }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Transaction ID</span>
                                <span>{{ $order->transaction_id }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping Method</span>
                                <span>{{ $order->shipping_method }}</span>
                            </li>

                        </ul>
                    </div>

                </div>


                <!-- Products -->
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

                            @foreach ($orderProducts as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="fw-semibold">{{ $product->product_name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>Rs.{{ $product->unit_price }}</td>
                                    <td class="fw-semibold">
                                        Rs.{{ $product->quantity * $product->unit_price }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>


                <!-- Totals -->
                <div class="row justify-content-end mt-4">

                    <div class="col-md-4">

                        <ul class="list-group">

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>Rs.{{ $order->subtotal }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping</span>
                                <span>RS.{{ $order->shipping_amount }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Discount</span>
                                <span class="text-danger">
                                    - RS.{{ $order->discount_amount }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-success">
                                    Rs.{{ $order->total_amount }}
                                </span>
                            </li>

                        </ul>

                    </div>

                </div>


                <!-- Notes -->
                <div class="mt-4">
                    <h6 class="fw-bold">Notes</h6>
                    <div class="p-3 bg-light rounded">
                        {{ $order->notes ?? 'No notes added.' }}
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
