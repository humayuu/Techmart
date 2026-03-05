@extends('admin.layout')
@section('main')
    <div class="card">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="mb-0">Manage Coupon</h6>
        </div>
        <div class="card-body">
            <div class="row">

                {{-- Edit FORM --}}
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card border shadow-none w-100">
                        <div class="card-body">
                            <form class="row g-3" action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Coupon Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('coupon_name') is-invalid @enderror"
                                        name="coupon_name" placeholder="Enter Coupon name"
                                        value="{{ $coupon->coupon_name }}">
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
                                        value="{{ $coupon->coupon_discount }}">
                                    @error('coupon_discount')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Valid Until <span class="text-danger">*</span></label>
                                    <input type="date" min="{{ now()->format('Y-m-d') }}"
                                        class="form-control @error('valid_until') is-invalid @enderror" name="valid_until"
                                        value="{{ $coupon->valid_until }}">
                                    @error('valid_until')
                                        <span class="text-danger fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="">
                                        <a class="btn btn-outline-primary px-4"
                                            href="{{ route('coupon.index') }}">Cancel</a>
                                        <button class="btn btn-dark">Save Changes</button>
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
