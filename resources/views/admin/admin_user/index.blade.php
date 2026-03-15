    @extends('admin.layout')
    @section('main')
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg"></i> Create Admin User
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>Admin user
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center" id="adminUser" style="min-width: 900px">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px">User</th>
                                <th style="width: 130px">Name</th>
                                <th style="width: 200px">Email</th>
                                <th style="width: 110px">Role</th>
                                <th style="width: 90px">Status</th>
                                <th style="width: 90px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
