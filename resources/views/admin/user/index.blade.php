@extends('admin.layout')

@section('page-title')
    Users <span class="badge bg-dark">{{ $totalUsers }}</span>
@endsection

@section('main')
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>All Users
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-6 text-center" id="userTable">
                    <thead class="table-light">
                        <tr>
                            <th class=" text-center">#</th>
                            <th class=" text-center">Name</th>
                            <th class=" text-center">Email</th>
                            <th class=" text-center">Phone</th>
                            <th class=" text-center">Last Seen</th>
                            <th class=" text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
