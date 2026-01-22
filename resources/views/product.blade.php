<!-- Product Area Start -->
<div class="product-area mt-5 pb-100px">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <div class="col-12">
                <!-- Tab Start -->
                <div class="tab-slider d-md-flex justify-content-md-between align-items-md-center">
                    <ul class="product-tab-nav nav justify-content-start align-items-center">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#newarrivals">
                                New Arrivals
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#toprated">
                                Special Offer
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#featured">
                                Featured
                            </button>
                        </li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
        </div>
        <!-- Section Title & Tab End -->

        <div class="row">
            <div class="col">
                <div class="tab-content mt-60px">
                    <!-- New Arrivals Tab -->
                    <div class="tab-pane fade show active" id="newarrivals">
                        <div class="row mb-n-30px">
                            <!-- Single Product Template - You will make this dynamic -->
                            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                <div class="product">
                                    <span class="badges">
                                        <span class="new">New</span>
                                    </span>
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                                alt="Product" />
                                            <img class="hover-image"
                                                src="{{ asset('frontend/assets/images/product-image/1.webp') }}"
                                                alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <span class="category"><a href="#">Accessories</a></span>
                                        <h5 class="title">
                                            <a href="single-product.html">Modern Smart Phone</a>
                                        </h5>
                                        <span class="price">
                                            <span class="new">$38.50</span>
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Cart">
                                            <i class="pe-7s-shopbag"></i>
                                        </button>
                                        <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Wishlist">
                                            <i class="pe-7s-like"></i>
                                        </button>
                                        <button class="action quickview" data-link-action="quickview" title="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="pe-7s-look"></i>
                                        </button>
                                        <button class="action compare" title="Compare" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Compare">
                                            <i class="pe-7s-refresh-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        </div>
                    </div>

                    <!-- Top Rated Tab -->
                    <div class="tab-pane fade" id="toprated">
                        <div class="row mb-n-30px">
                            <!-- Single Product Template - You will make this dynamic -->
                            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                <div class="product">
                                    <span class="badges">
                                        <span class="sale">-10%</span>
                                    </span>
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img src="{{ asset('frontend/assets/images/product-image/2.webp') }}"
                                                alt="Product" />
                                            <img class="hover-image"
                                                src="{{ asset('frontend/assets/images/product-image/2.webp') }}"
                                                alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <span class="category"><a href="#">Accessories</a></span>
                                        <h5 class="title">
                                            <a href="single-product.html">Bluetooth Headphone</a>
                                        </h5>
                                        <span class="price">
                                            <span class="old">$48.50</span>
                                            <span class="new">$38.50</span>
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Cart">
                                            <i class="pe-7s-shopbag"></i>
                                        </button>
                                        <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Wishlist">
                                            <i class="pe-7s-like"></i>
                                        </button>
                                        <button class="action quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="pe-7s-look"></i>
                                        </button>
                                        <button class="action compare" title="Compare" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Compare">
                                            <i class="pe-7s-refresh-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        </div>
                    </div>

                    <!-- Featured Tab -->
                    <div class="tab-pane fade" id="featured">
                        <div class="row mb-n-30px">
                            <!-- Single Product Template - You will make this dynamic -->
                            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                <div class="product">
                                    <span class="badges">
                                        <span class="new">Featured</span>
                                    </span>
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img src="{{ asset('frontend/assets/images/product-image/3.webp') }}"
                                                alt="Product" />
                                            <img class="hover-image"
                                                src="{{ asset('frontend/assets/images/product-image/3.webp') }}"
                                                alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <span class="category"><a href="#">Accessories</a></span>
                                        <h5 class="title">
                                            <a href="single-product.html">Smart Music Box</a>
                                        </h5>
                                        <span class="price">
                                            <span class="new">$38.50</span>
                                        </span>
                                    </div>
                                    <div class="actions">
                                        <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Cart">
                                            <i class="pe-7s-shopbag"></i>
                                        </button>
                                        <button class="action wishlist" title="Wishlist" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Wishlist">
                                            <i class="pe-7s-like"></i>
                                        </button>
                                        <button class="action quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="pe-7s-look"></i>
                                        </button>
                                        <button class="action compare" title="Compare" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-Compare">
                                            <i class="pe-7s-refresh-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End -->

<script>
    const url = "http://127.0.0.1:8000/product";

    const productData = async () => {
        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const products = await response.json();
            console.log(products)

            products.data.featured.forEach(product => {
                console.log(product.product_thumbnail);
            });
        } catch (error) {
            console.error("Fetch failed:", error);
        }
    };

    productData()
</script>
