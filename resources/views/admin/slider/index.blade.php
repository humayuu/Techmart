@extends('admin.layout');
@section('main')
@section('page-title')
    Sliders <span class="badge text-bg-dark">{{ $totalSlider }}</span>
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-12">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Title"
                                    value="{{ old('title') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Slider image</label>
                                <input type="file" name="slider" class="form-control">

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
                            @if ($sliders->count() > 0)
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 7%;">#</th>
                                            <th style="width: 25%;">Title</th>
                                            <th style="width: 35%;">Slider Image</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 25%;">Action</th>
                                        </tr>
                                    </thead>
                            @endif
                            <tbody>
                                @forelse ($sliders as $slider)
                                    <tr>
                                        <td>{{ $sliders->firstItem() + $loop->index }}</td>
                                        <td>{{ $slider->title }}</td>
                                        <td><img class="w-75 img-thumbnail" src="{{ asset($slider->slider_image) }}"
                                                alt=""></td>
                                        <td>
                                            @php
                                                $status = $slider->status == 'active' ? 'Active' : 'Inactive';
                                                $class = $slider->status == 'active' ? 'success' : 'dark';
                                                $icon = $slider->status == 'active' ? 'thumbs-up' : 'thumbs-down';
                                            @endphp
                                            <span
                                                class="badge text-bg-{{ $class }} fs-6">{{ $status }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-5">

                                                <!-- Edit Button -->
                                                <a href="{{ route('slider.edit', $slider->id) }}" class="text-primary"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="Edit info">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                <!-- Update Status -->
                                                <a href="{{ route('slider.status', $slider->id) }}"
                                                    class="text-{{ $class }}" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Edit info">
                                                    <i class="bi bi-hand-{{ $icon }}-fill"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('slider.destroy', $slider->id) }}"
                                                    method="POST" class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="delete" type="submit"
                                                        class="text-danger border-0 bg-transparent p-0 d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Delete" style="cursor: pointer; line-height: 1;">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        No Slider Found!
                                    </div>
                                @endforelse
                            </tbody>
                            </table>
                            {{-- Pagination --}}
                            <nav class="float-end mt-0" aria-label="Page navigation">
                                {{ $sliders->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
@endsection
