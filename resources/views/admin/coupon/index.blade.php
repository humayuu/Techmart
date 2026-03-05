@extends('admin.layout')

@section('page-title')
    Coupon <span class="badge text-bg-dark">{{ $totalCoupons }}</span>
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="mb-0">Manage Coupon</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- ADD FORM --}}
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('coupon.store') }}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Coupon Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('coupon_name') is-invalid @enderror"
                                        name="coupon_name" placeholder="Enter Coupon name" value="{{ old('coupon_name') }}">
                                    @error('coupon_name')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">
                                        Coupon Discount <span class="text-muted fw-normal">(%)</span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        class="form-control @error('coupon_discount') is-invalid @enderror"
                                        name="coupon_discount" placeholder="Enter Coupon Discount"
                                        value="{{ old('coupon_discount') }}">
                                    @error('coupon_discount')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Valid Until <span class="text-danger">*</span></label>
                                    <input type="date" min="{{ now()->format('Y-m-d') }}"
                                        class="form-control @error('valid_until') is-invalid @enderror" name="valid_until"
                                        value="{{ old('valid_until', now()->format('Y-m-d')) }}">
                                    @error('valid_until')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-dark" type="submit">Add Coupon</button>
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
                                <table class="table align-middle" id="couponTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Coupon name</th>
                                            <th>Coupon Discount</th>
                                            <th>Valid Until</th>
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
