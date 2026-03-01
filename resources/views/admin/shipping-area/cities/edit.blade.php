@extends('admin.layout')

@section('page-title')
    Edit City
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="mb-0">Manage Cities</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- Edit FORM --}}
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('city.update', $city->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Province<span class="text-danger">*</span></label>
                                    <select class="form-select @error('province_id') is-invalid @enderror"
                                        name="province_id">
                                        <option selected disabled>Select province</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ $city->province_id == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">City Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Enter City name" value="{{ $city->name }}">
                                    @error('name')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="">
                                        <button class="btn btn-primary">Save Changes</button>
                                        <a class="btn btn-outline-dark" href="{{ route('city.index') }}">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
