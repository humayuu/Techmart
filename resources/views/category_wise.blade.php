@extends('layout')
@section('main')
    <div class="main-wrapper">
        <!-- Shop Page Start  -->
        <div class="shop-category-area pt-100px pb-100px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="mb-5"><span class="text-secondary">Category:</span> <span
                                class="fw-bold">{{ $category->category_name }}</span>
                        </h1>
                        <!-- Shop Top Area Start -->
                        <div class="shop-top-bar d-flex">
                            <p class="compare-product"> <span>{{ $products->count() }}</span> Product Found of
                                <span>{{ $products->total() }}</span>
                            </p>
                            <!-- Left Side End -->
                            <div class="shop-tab nav">
                                <button class="active" data-bs-target="#shop-grid" data-bs-toggle="tab">
                                    <i class="fa fa-th" aria-hidden="true"></i>
                                </button>
                                <button data-bs-target="#shop-list" data-bs-toggle="tab">
                                    <i class="fa fa-list" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex align-items-center">
                                <div class="shot-product">
                                    <p>Sort By:</p>
                                </div>
                                <!-- Single Wedge End -->
                                <div class="header-bottom-set dropdown">
                                    <button class="dropdown-toggle header-action-btn" data-bs-toggle="dropdown">Default <i
                                            class="fa fa-angle-down"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><button onclick="SortByASC()" class="dropdown-item">Name, A to Z</button></li>
                                        <li><button onclick="SortByDESC()" class="dropdown-item">Name, Z to A</button></li>
                                        <li><button onclick="SortByPriceASC()" class="dropdown-item">Price, low to
                                                high</button></li>
                                        <li><button onclick="SortByPriceDESC()" class="dropdown-item">Price, high to
                                                low</button></li>
                                        <li><button onclick="SortByLatest()" class="dropdown-item">Sort By new</button></li>
                                        <li><button onclick="SortByOldest()" class="dropdown-item">Sort By old</button></li>
                                    </ul>
                                </div>
                                <!-- Single Wedge Start -->
                            </div>
                            <!-- Right Side End -->
                        </div>
                        <!-- Shop Top Area End -->
                        <!-- Shop Bottom Area Start -->
                        <div class="shop-bottom-area">
                            <!-- Tab Content Area Start -->
                            <div class="row">
                                <div class="col">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="shop-grid">
                                            <div class="row mb-n-30px">
                                                @foreach ($products as $item)
                                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                                        <!-- Single Prodect -->
                                                        <div class="product">
                                                            <div class="thumb">
                                                                <a href="{{ route('product.detail', $item->id) }}"
                                                                    class="image">
                                                                    <img src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                                        alt="Product" />
                                                                    <img class="hover-image"
                                                                        src="{{ asset('images/products/' . $item->product_thumbnail) }}"
                                                                        alt="Product" />
                                                                </a>
                                                            </div>
                                                            <div class="content">
                                                                <span class="category"><a
                                                                        href="#">{{ $item->category->category_name }}</a></span>
                                                                <h5 class="title"><a
                                                                        href="{{ route('product.detail', $item->id) }}">{{ $item->product_name }}
                                                                    </a>
                                                                </h5>
                                                                <span class="price">
                                                                    @if ($item->discount_price > 0)
                                                                        @php
                                                                            $finalPrice =
                                                                                $item->selling_price -
                                                                                $item->discount_price;
                                                                        @endphp
                                                                        <span
                                                                            class="old">${{ $item->selling_price }}</span>
                                                                        <span class="new">${{ $finalPrice }}</span>
                                                                    @else
                                                                        <span
                                                                            class="new">${{ $item->selling_price }}</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="actions">
                                                                <button title="Add To Cart" class="action add-to-cart"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal-Cart"><i
                                                                        class="pe-7s-shopbag"></i></button>
                                                                <button class="action wishlist" title="Wishlist"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal-Wishlist"><i
                                                                        class="pe-7s-like"></i></button>
                                                                <button class="action quickview"
                                                                    data-link-action="quickview" title="Quick view"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                                        class="pe-7s-look"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="tab-pane fade mb-n-30px" id="shop-list">
                                            <div class="shop-list-wrapper mb-30px">
                                                @foreach ($products as $tabProduct)
                                                    <div class="row">
                                                        <div class="col-md-5 col-lg-5 col-xl-4 mb-lm-30px">
                                                            <div class="product">
                                                                <div class="thumb">
                                                                    <a href="{{ route('product.detail', $tabProduct->id) }}"
                                                                        class="image">
                                                                        <img src="{{ asset('images/products/' . $tabProduct->product_thumbnail) }}"
                                                                            alt="Product" />
                                                                        <img class="hover-image"
                                                                            src="{{ asset('images/products/' . $tabProduct->product_thumbnail) }}"
                                                                            alt="Product" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 col-lg-7 col-xl-8">
                                                            <div class="content-desc-wrap">
                                                                <div class="content">
                                                                    <span class="category"><a
                                                                            href="#">{{ $tabProduct->category->category_name }}</a></span>
                                                                    <h5 class="title"><a
                                                                            href="{{ route('product.detail', $tabProduct->id) }}">{{ $tabProduct->product_name }}</a>
                                                                    </h5>
                                                                    <p>{{ $tabProduct->short_description }}</p>
                                                                </div>
                                                                <div class="box-inner">
                                                                    <span class="price">
                                                                        @if ($tabProduct->discount_price > 0)
                                                                            @php
                                                                                $finalPrice =
                                                                                    $tabProduct->selling_price -
                                                                                    $tabProduct->discount_price;
                                                                            @endphp
                                                                            <span
                                                                                class="old">${{ $tabProduct->selling_price }}</span>
                                                                            <span
                                                                                class="new">${{ $finalPrice }}</span>
                                                                        @else
                                                                            <span
                                                                                class="new">${{ $tabProduct->selling_price }}</span>
                                                                        @endif
                                                                    </span>
                                                                    <div class="actions">
                                                                        <button title="Add To Cart"
                                                                            class="action add-to-cart"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal-Cart"><i
                                                                                class="pe-7s-shopbag"></i></button>
                                                                        <button class="action wishlist" title="Wishlist"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal-Wishlist"><i
                                                                                class="pe-7s-like"></i></button>
                                                                        <button class="action quickview"
                                                                            data-link-action="quickview"
                                                                            title="Quick view" data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModal"><i
                                                                                class="pe-7s-look"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Content Area End -->
                            <!--  Pagination Area Start -->
                            <div class="pro-pagination-style text-center text-lg-end" data-aos="fade-up"
                                data-aos-delay="200">
                                <div class="pages d-flex justify-content-end">
                                    {{ $products->links() }}
                                </div>
                            </div>
                            <!--  Pagination Area End -->
                        </div>
                        <!-- Shop Bottom Area End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Page End  -->
    </div>


    <script>
        const id = {{ Js::from($category->id) }};

        // Function to render products in grid view
        const renderGridProducts = (products) => {
            let html = '';
            products.forEach(item => {
                const finalPrice = item.discount_price > 0 ?
                    item.selling_price - item.discount_price :
                    item.selling_price;

                html += `
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-30px">
                    <div class="product">
                        <div class="thumb">
                            <a href="/product/detail/${item.id}" class="image">
                                <img src="/images/products/${item.product_thumbnail}" alt="Product" />
                                <img class="hover-image" src="/images/products/${item.product_thumbnail}" alt="Product" />
                            </a>
                        </div>
                        <div class="content">
                            <span class="category"><a href="#"> ${item.category.category_name}</a></span>
                            <h5 class="title"><a href="/product/detail/${item.id}">${item.product_name}</a></h5>
                            <span class="price">
                                ${item.discount_price > 0 ? `<span class="old">$${item.selling_price}</span>` : ''}
                                <span class="new">$${finalPrice}</span>
                            </span>
                        </div>
                        <div class="actions">
                            <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
                                <i class="pe-7s-shopbag"></i>
                            </button>
                            <button class="action wishlist" title="Wishlist" data-bs-toggle="modal" data-bs-target="#exampleModal-Wishlist">
                                <i class="pe-7s-like"></i>
                            </button>
                            <button class="action quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="pe-7s-look"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });
            return html;
        };

        // Function to render products in list view
        const renderListProducts = (products) => {
            let html = '';
            products.forEach(item => {
                const finalPrice = item.discount_price > 0 ?
                    item.selling_price - item.discount_price :
                    item.selling_price;

                html += `
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-xl-4 mb-lm-30px">
                        <div class="product">
                            <div class="thumb">
                                <a href="/product/detail/${item.id}" class="image">
                                    <img src="/images/products/${item.product_thumbnail}" alt="Product" />
                                    <img class="hover-image" src="/images/products/${item.product_thumbnail}" alt="Product" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 col-xl-8">
                        <div class="content-desc-wrap">
                            <div class="content">
                                <span class="category"><a href="#">${item.category.category_name}</a></span>
                                <h5 class="title"><a href="/product/detail/${item.id}">${item.product_name}</a></h5>
                                <p>${item.short_description || ''}</p>
                            </div>
                            <div class="box-inner">
                                <span class="price">
                                    ${item.discount_price > 0 ? `<span class="old">$${item.selling_price}</span>` : ''}
                                    <span class="new">$${finalPrice}</span>
                                </span>
                                <div class="actions">
                                    <button title="Add To Cart" class="action add-to-cart" data-bs-toggle="modal" data-bs-target="#exampleModal-Cart">
                                        <i class="pe-7s-shopbag"></i>
                                    </button>
                                    <button class="action wishlist" title="Wishlist" data-bs-toggle="modal" data-bs-target="#exampleModal-Wishlist">
                                        <i class="pe-7s-like"></i>
                                    </button>
                                    <button class="action quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="pe-7s-look"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            });
            return html;
        };

        // Main sorting function
        const sortProducts = async (sortType) => {
            try {
                const response = await fetch(`/product/category/${id}/sorting`);
                const data = await response.json();

                if (!data.status) {
                    console.error('Error:', data.message);
                    return;
                }

                // Get the products based on sort type
                let products;
                switch (sortType) {
                    case 'asc':
                        products = data.asc;
                        break;
                    case 'desc':
                        products = data.desc;
                        break;
                    case 'price_asc':
                        products = data.ascPrice;
                        break;
                    case 'price_desc':
                        products = data.descPrice;
                        break;
                    case 'latest':
                        products = data.latest;
                        break;
                    case 'oldest':
                        products = data.oldest;
                        break;
                    default:
                        products = data.latest;
                }

                // Update both grid and list views
                document.querySelector('#shop-grid .row').innerHTML = renderGridProducts(products);
                document.querySelector('#shop-list .shop-list-wrapper').innerHTML = renderListProducts(products);

            } catch (error) {
                console.error('Error:', error);
            }
        };

        // Individual sort functions
        const SortByASC = () => sortProducts('asc');
        const SortByDESC = () => sortProducts('desc');
        const SortByPriceASC = () => sortProducts('price_asc');
        const SortByPriceDESC = () => sortProducts('price_desc');
        const SortByLatest = () => sortProducts('latest');
        const SortByOldest = () => sortProducts('oldest');
    </script>
@endsection
