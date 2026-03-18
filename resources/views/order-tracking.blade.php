@extends('layout')
@section('main')
    <div class="container py-5">
        <div class="card border rounded-4 shadow-sm p-4" style="max-width:720px;margin:auto;">

            <!-- Invoice Header -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <p class="text-muted small mb-1 text-uppercase fw-semibold">Invoice</p>
                    <h4 class="fw-bold text-primary">#{{ $order->id }}</h4>
                </div>
                <div class="text-end">
                    <p class="text-muted small mb-1">
                        Invoice Date:
                        <strong class="text-dark">{{ $order->created_at->format('d-m-Y') }}</strong>
                    </p>

                    @php
                        $daysToAdd = $order->shipping_method === 'standard' ? 7 : 3;
                        $expectedDate = $order->created_at->copy()->addDays($daysToAdd)->format('d-m-Y');
                    @endphp

                    <p class="text-muted small mb-1">
                        Expected:
                        <strong class="text-dark">{{ $expectedDate }}</strong>
                    </p>
                </div>

            </div>

            <hr class="mb-4" />
            <!-- Current Status Badge -->
            <div class="mb-4">
                <span class="badge bg-primary-subtle text-primary border border-primary rounded-pill px-3 py-2 fs-6">
                    <i class="fa-solid fa-circle fa-2xs me-1"></i> {{ ucfirst($order->status) }}
                </span>
            </div>

            <!-- Progress Timeline -->
            @php
                $steps = [
                    'pending' => 'clock',
                    'processing' => 'chart-diagram',
                    'shipped' => 'truck',
                    'delivered' => 'box-open',
                ];

                $statusOrder = array_keys($steps);
                $currentIndex = array_search($order->status, $statusOrder);
            @endphp

            <div class="d-flex align-items-start justify-content-between text-center">
                @foreach ($steps as $step => $icon)
                    @php
                        $stepIndex = array_search($step, $statusOrder);
                        $isDone = $stepIndex < $currentIndex;
                        $isActive = $stepIndex === $currentIndex;
                    @endphp

                    {{-- Step Circle --}}
                    <div class="d-flex flex-column align-items-center flex-fill">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white {{ $isDone || $isActive ? 'bg-primary' : 'bg-secondary' }}"
                            style="width:48px;height:48px;">
                            <i class="fa-solid fa-{{ $isDone ? 'check' : $icon }} fs-5"></i>
                        </div>
                        <small class="mt-3 fw-semibold">{{ ucfirst($step) }}</small>
                    </div>

                    {{-- Connector (render between steps, not after last) --}}
                    @if (!$loop->last)
                        <div class="flex-fill d-flex align-items-center" style="margin-top:24px;">
                            <div
                                class="w-100 border-top border-2 {{ $stepIndex < $currentIndex ? 'border-primary' : 'border-secondary' }}">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- End Timeline -->

        </div>
    </div>
@endsection
