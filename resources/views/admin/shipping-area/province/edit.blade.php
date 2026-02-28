@extends('admin.layout')

@section('page-title')
    Edit Province
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="mb-0">Manage Province</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- ADD FORM --}}
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('province.update', $province->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-12">
                                    <label class="form-label">Province Name</label>
                                    <input type="text" class="form-control mb-3 @error('name') is-invalid  @enderror"
                                        name="name" placeholder="Province name" autofocus value="{{ $province->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="">
                                        <button class="btn btn-primary" type="submit">Save Changes</button>
                                        <a href="{{ route('province.index') }}" class="btn btn-outline-dark px-3">Cancel</a>

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
