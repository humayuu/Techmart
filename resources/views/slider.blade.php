  <!-- Hero/Intro Slider Start -->
  <div class="section">
      <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1">
          <!-- Hero slider Active -->
          <div class="swiper-wrapper">
              @php
                  $sliders = \App\Models\Slider::where('status', 'active')->get();
              @endphp
              @foreach ($sliders as $slider)
                  <!-- Single slider item -->
                  <div class="hero-slide-item slider-height swiper-slide bg-color1"
                      data-bg-image="{{ asset('images/slider/' . $slider->slider_image) }}">
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
          <!-- Add Pagination -->
          <div class="swiper-pagination swiper-pagination-white"></div>
          <!-- Add Arrows -->
          <div class="swiper-buttons">
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
          </div>
      </div>
  </div>
  <!-- Hero/Intro Slider End -->
