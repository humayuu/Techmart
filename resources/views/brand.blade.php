@php
    $brands = App\Models\Brand::all();
@endphp
<!-- Brand area start -->
<div class="brand-area pt-100px pb-100px">
    <div class="container">
        <div class="brand-slider swiper-container">
            <div class="swiper-wrapper align-items-center">
                @forelse ($brands as $brand)
                    <div class="swiper-slide brand-slider-item text-center">
                        <a href="{{ route('brand.wise.product', $brand->id) }}"><img class="img-fluid"
                                src="{{ asset('images/brands/' . $brand->brand_logo) }}" alt="" /></a>
                    </div>
                @empty
                    <div class="alert alert-danger">No Record Found!</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- Brand area end -->
