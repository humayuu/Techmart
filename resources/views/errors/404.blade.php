@extends('layout')
@section('main')
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center">
                    <div class="mb-4">
                        <h1 class="display-1 fw-bold text-primary">404</h1>
                        <h2 class="display-6 mb-3">Oops! Page Not Found</h2>
                        <p class="text-muted fs-5 mb-4">
                            The page you're looking for doesn't exist or has been moved.
                        </p>
                    </div>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="javascript:history.back()" class="px-4">
                            <i class="bi bi-arrow-left me-2"></i>Go Back
                        </a>
                        <a href="{{ url('/') }}" class="px-4">
                            <i class="bi bi-house-door me-2"></i>Go to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
