@extends('admin.layout')

@section('page-title')
    Provinces
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="mb-0">Manage Province</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- ADD FORM --}}
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('province.store') }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <label class="form-label">Province Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Province name"
                                        autofocus>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="form-label fw-bold">Status</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" value="1"
                                                id="activeRadio" checked>
                                            <label class="form-check-label fw-bold" for="activeRadio">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_active" value="0"
                                                id="inactiveRadio">
                                            <label class="form-check-label fw-bold" for="inactiveRadio">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Add Province</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- YAJRA TABLE --}}
                <div class="col-12 col-lg-8 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle" id="provinceTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
