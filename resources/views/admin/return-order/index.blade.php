@extends('admin.layout')

@section('page-title')
    Returns <span class="badge bg-dark">{{ $totalReturnOrders }}</span>
@endsection
@section('main')
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">Return Orders
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-6 text-center" id="return">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>City</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
