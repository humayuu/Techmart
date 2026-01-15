@extends('admin.layout');
@section('main')
@section('page-title')
    Sliders
@endsection
<div class="card">
    <div class="card-header py-3 bg-dark text-white">
        <h6 class="mb-0">Add Slider</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-6 d-flex mx-auto">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <form method="POST" action="{{ route('slider.update', $slider->id) }}"
                            enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" placeholder="Enter Title" value="{{ $slider->title }}">
                                @error('title')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror


                            </div>
                            <div class="col-12">
                                <label class="form-label">Slider image</label>
                                <input type="file" name="slider"
                                    class="form-control @error('slider') is-invalid @enderror">
                                <img class="w-25 mt-3 img-thumbnail"
                                    src="{{ asset('images/slider/' . $slider->slider_image) }}" alt="">
                                @error('slider')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror


                            </div>

                            <div class="col-12 mt-4">
                                <div class="">
                                    <button class="btn btn-primary">Save Changes</button>
                                    <a class="btn btn-outline-dark" href="{{ route('slider.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
