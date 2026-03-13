    @extends('admin.layout')

    @section('page-title')
        Delivered <span class="badge bg-dark">{{ $totalDelivered }}</span>
    @endsection

    @section('main')
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0">Delivered Orders
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 fs-6 text-center" id="delivered">
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
        <script>
            function updateStatus(orderId, status) {
                document.getElementById('status-' + orderId).value = status;
                document.getElementById('form-' + orderId).submit();
            }
        </script>
    @endsection
