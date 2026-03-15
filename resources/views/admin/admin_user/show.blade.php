@extends('admin.layout')
@section('main')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4">

            {{-- Header --}}
            <div class="card-header bg-dark text-white px-4 py-3 rounded-top-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user fs-5"></i>
                        <h5 class="mb-0 fw-bold">Admin Profile</h5>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                {{-- Profile Top Banner --}}
                <div class="bg-secondary bg-opacity-10 px-4 py-4 border-bottom">
                    <div class="d-flex align-items-center gap-4">

                        {{-- Profile Image --}}
                        <div class="rounded-circle overflow-hidden border border-3 border-dark"
                            style="width:80px; height:80px; min-width:80px;">
                            @if ($adminUser->profile_image)
                                <img src="{{ asset('images/profile_image/' . $adminUser->profile_image) }}"
                                    alt="Profile Image" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div class="bg-dark d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="fas fa-user text-white" style="font-size: 36px;"></i>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h4 class="mb-1 fw-bold">{{ $adminUser->name }}</h4>
                            <p class="mb-1 text-muted fs-6">
                                <i class="fas fa-envelope me-1"></i> {{ $adminUser->email }}
                            </p>
                            <span class="badge bg-primary px-3 py-2">
                                {{ ucwords(str_replace('_', ' ', $adminUser->role ?? 'Admin')) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info List --}}
                <div class="px-4 py-3">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-hashtag me-2 text-secondary"></i> User ID
                            </span>
                            <span class="fw-bold fs-6"># {{ $adminUser->id }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-user me-2 text-secondary"></i> Name
                            </span>
                            <span class="fw-medium fs-6">{{ $adminUser->name }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-envelope me-2 text-secondary"></i> Email
                            </span>
                            <span class="fw-medium fs-6">{{ $adminUser->email }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-shield-alt me-2 text-secondary"></i> Role
                            </span>
                            <span class="badge bg-primary px-3 py-2 fs-6">
                                {{ $adminUser->role ?? 'Admin' }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-key me-2 text-secondary"></i> Access
                            </span>
                            <span class="d-flex flex-wrap gap-2 justify-content-end">
                                @forelse($adminUser->access ?? [] as $item)
                                    <span class="badge bg-dark px-3 py-2 fs-6">
                                        {{ ucfirst($item) }}
                                    </span>
                                @empty
                                    <span class="text-muted fst-italic">No access assigned</span>
                                @endforelse
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-circle-dot me-2 text-secondary"></i> Status
                            </span>
                            @if ($adminUser->status == 1)
                                <span class="badge bg-success px-3 py-2 fs-6">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 fs-6">
                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                </span>
                            @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted fw-semibold fs-6">
                                <i class="fas fa-calendar-alt me-2 text-secondary"></i> Join Date
                            </span>
                            <span class="fw-medium fs-6">
                                {{ $adminUser->created_at->format('d M Y') }}
                            </span>
                        </li>

                    </ul>
                </div>

                {{-- Footer Back Button --}}
                <div class="px-4 pb-4">
                    <a href="{{ url()->previous() }}" class="btn btn-dark px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
