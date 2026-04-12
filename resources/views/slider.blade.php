@php
    $homeSliders = $homeSliders ?? collect();
@endphp
@if ($homeSliders->isNotEmpty())
    <!-- Hero/Intro Slider Start -->
    <section class="section p-0 hero-slider-section" aria-label="Promotional banners">
        <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1">
            <div class="swiper-wrapper">
                @foreach ($homeSliders as $slider)
                    <div class="hero-slide-item slider-height swiper-slide bg-color1"
                        data-bg-image="{{ asset('images/slider/'.$slider->slider_image) }}">
                        <div class="container h-100">
                            <div class="row h-100">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                    <div class="hero-slide-content slider-animated-1">
                                        <span class="category">Welcome To Techmart</span>
                                        <h2 class="title-1 text-dark">
                                            {{ $slider->title }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination swiper-pagination-white"></div>
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <!-- Hero/Intro Slider End -->
@endif
