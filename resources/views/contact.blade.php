@extends('layout')
@section('main')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-9">

                {{-- Card wrapper --}}
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        {{-- Title --}}
                        <h2 class="fw-bold mb-1 text-center">Contact Us</h2>
                        <p class="text-muted mb-4 text-center">We'll get back to you as soon as possible.</p>

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                @foreach ($errors->all() as $error)
                                    <div class="small">• {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success py-2 small">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('send.email') }}" method="POST">
                            @csrf

                            <div class="row g-3">

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Your full name" value="{{ old('name', Auth::user()->name ?? '') }}" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="your@email.com"
                                        value="{{ old('email', Auth::user()->email ?? '') }}" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Subject --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                    <input name="subject" type="text"
                                        class="form-control @error('subject') is-invalid @enderror"
                                        placeholder="What is this about?" value="{{ old('subject') }}" />
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Message --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Write your message here...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Submit --}}
                                <div class="col-lg-12 text-center">
                                    <button class="bg-primary text-white px-5 border-5 p-2 mt-2" type="submit">
                                        Send Message
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
                {{-- End Card --}}

            </div>
        </div>
    </div>

@endsection
