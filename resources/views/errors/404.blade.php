@extends('layout')
@section('main')
    <div class="py-5 my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center">
                    <div class="card border-0 shadow-sm rounded-4 py-5 px-3">
                        <div class="card-body">
                            <h1 class="display-1 fw-bold text-primary">404</h1>
                            <h2 class="h4 fw-bold mb-3">Page not found</h2>
                            <p class="text-muted mb-4">
                                The page you’re looking for doesn’t exist or was moved.
                            </p>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fa fa-arrow-left me-2"></i>Go back
                                </a>
                                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fa fa-house me-2"></i>Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
