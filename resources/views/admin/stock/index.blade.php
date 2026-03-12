    @extends('admin.layout')
    @section('main')
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('stock.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg"></i> Add Stock
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>Product Stock
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 fs-6 text-center" id="stock">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Stock</th>
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
