@extends('layout')
@section('main')
    <div class="account-dashboard pt-100px pb-100px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 col-lg-7">

                    <h4 class="mb-1">Return Order Request</h4>
                    <p class="text-muted mb-4">Fill in the details below to submit your return request.</p>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('return.store') }}">
                        @csrf

                        {{-- Hidden order id --}}
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        {{-- Order Info (read only) --}}
                        <div class="card mb-4 border">
                            <div class="card-body d-flex flex-wrap gap-4">
                                <div>
                                    <small class="text-muted d-block">Order ID</small>
                                    <strong>#{{ $order->id }}</strong>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Order Date</small>
                                    <strong>{{ $order->created_at->format('d M Y') }}</strong>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Order Total</small>
                                    <strong>Rs.{{ number_format($order->total_amount, 2) }}</strong>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Reason --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Reason for Return <span class="text-danger">*</span>
                            </label>
                            <select name="reason" class="form-select" required>
                                <option value="">— Select a reason —</option>
                                <option value="defective" {{ old('reason') === 'defective' ? 'selected' : '' }}>
                                    Defective / Damaged Product</option>
                                <option value="wrong_item" {{ old('reason') === 'wrong_item' ? 'selected' : '' }}>
                                    Wrong Item Received</option>
                                <option value="not_as_described"
                                    {{ old('reason') === 'not_as_described' ? 'selected' : '' }}>Not as Described
                                </option>
                                <option value="changed_mind" {{ old('reason') === 'changed_mind' ? 'selected' : '' }}>
                                    Changed My Mind
                                </option>
                                <option value="damaged_in_shipping"
                                    {{ old('reason') === 'damaged_in_shipping' ? 'selected' : '' }}>Damaged in Shipping
                                </option>
                                <option value="other" {{ old('reason') === 'other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                            @error('reason')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Additional Details</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe the issue in detail...">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="bg-dark text-white p-2 rounded">Submit Return
                                Request</button>
                            <a href="{{ route('dashboard') }}" class="bg-primary text-white p-2 rounded">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
