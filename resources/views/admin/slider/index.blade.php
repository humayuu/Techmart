@extends('admin.layout');
@section('main')
@section('page-title')
    Sliders <span class="badge text-bg-dark">{{ $totalSliders }}</span>
@endsection
<div class="card">
    <div class="card-header py-3 bg-dark text-white">
        <h6 class="mb-0">Add Slider</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" placeholder="Enter Title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Slider image</label>
                                <input type="file" name="slider"
                                    class="form-control @error('slider') is-invalid @enderror">
                                @error('slider')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary">Add Slider</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle" id="sliderTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 7%;">#</th>
                                        <th style="width: 25%;">Title</th>
                                        <th style="width: 35%;">Slider Image</th>
                                        <th style="width: 20%;">Status</th>
                                        <th style="width: 25%;">Action</th>
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
        </div><!--end row-->
    </div>
</div>
@endsection
