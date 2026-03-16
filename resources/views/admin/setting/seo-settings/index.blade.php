@extends('admin.layout')

@section('page-title')
    SEO Settings
@endsection

@section('main')
    <div class="card">
        <div class="card-header py-3 bg-dark text-white">
            <h6 class="mb-0">
                <i class="bi bi-gear-fill me-2"></i>Update SEO Settings
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('seo.update', $seoSettings->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Left column --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                            name="meta_title" placeholder="Enter meta title"
                                            value="{{ old('meta_title', $seoSettings->meta_title) }}" autofocus>
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Meta Author</label>
                                        <input type="text"
                                            class="form-control @error('meta_author') is-invalid @enderror"
                                            name="meta_author" placeholder="Enter meta author"
                                            value="{{ old('meta_author', $seoSettings->meta_author) }}">
                                        @error('meta_author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text"
                                            class="form-control @error('meta_keyword') is-invalid @enderror"
                                            name="meta_keyword" placeholder="Enter meta keywords"
                                            value="{{ old('meta_keyword', $seoSettings->meta_keyword) }}">
                                        @error('meta_keyword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right column --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-12">
                                        <label class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" rows="4" name="meta_description"
                                            placeholder="Enter meta description">{{ old('meta_description', $seoSettings->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Google Analytics Script</label>
                                        <textarea class="form-control @error('google_analytics') is-invalid @enderror" rows="4" name="google_analytics"
                                            placeholder="Paste your GA script here">{{ old('google_analytics', $seoSettings->google_analytics) }}</textarea>
                                        @error('google_analytics')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i>Update Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
