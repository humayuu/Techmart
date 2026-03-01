@extends('admin.layout')

@section('page-title')
    Cities <span class="badge text-bg-dark">{{ $totalCities }}</span>
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="mb-0">Manage Cities</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- ADD FORM --}}
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('city.store') }}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Province<span class="text-danger">*</span></label>
                                    <select class="form-select @error('province_id') is-invalid @enderror"
                                        name="province_id">
                                        <option selected disabled>Select province</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">City Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Enter City name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger fs-6">{{ $message }}</span>
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
                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Add City</button>
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
                                <table class="table align-middle" id="cityTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Province</th>
                                            <th>Name</th>
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

            </div>
        </div>
    </div>
@endsection
