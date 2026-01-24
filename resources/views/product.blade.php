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
                            <button class="nav-link" onclick="NewArrival()">
                                New Arrivals
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" onclick="SpecialOffer()">
                                Special Offer
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" onclick="FeaturedProduct()">
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
                    <div class="tab-pane fade show active" id="newArrivals">
                        <div class="row mb-n-30px">
                        </div>
                    </div>

                    <!-- Top Rated Tab -->
                    <div class="tab-pane fade" id="specialOffer">
                        <div class="row mb-n-30px">
                        </div>
                    </div>

                    <!-- Featured Tab -->
                    <div class="tab-pane fade" id="featured">
                        <div class="row mb-n-30px">
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

    const newArriveRow = document.querySelector('#newArrivals .row');
    const specialOfferRow = document.querySelector('#specialOffer .row');
    const featuredRow = document.querySelector('#featured .row');

    const newArriveTab = document.getElementById('newArrivals');
    const specialOfferTab = document.getElementById('specialOffer');
    const featuredTab = document.getElementById('featured');

    const buttons = document.querySelectorAll('.product-tab-nav .nav-link');

    let productsData = null;

    const productData = async () => {
        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            productsData = await response.json();

            NewArrival();
        } catch (error) {
            console.error("Fetch failed:", error);
        }
    };
    const generateProductCard = (product, tabType = 'new') => {
        const imagePath = product.image_url;

        // Fixed price calculation
        const sellingPrice = parseFloat(product.selling_price) || 0;
        const discountPrice = parseFloat(product.discount_price) || 0;

        // Calculate final price: selling_price - discount_price
        const finalPrice = discountPrice > 0 ? sellingPrice - discountPrice : sellingPrice;
        const hasDiscount = discountPrice > 0;

        const productName = product.product_name.length > 50 ?
            product.product_name.substring(0, 50) + '...' :
            product.product_name;

        const categoryName = product.category_display || 'Uncategorized';

        return `<div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
        <div class="product h-100 d-flex flex-column">
            <div class="thumb position-relative overflow-hidden d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                <a href="single-product.html" class="image">
                    <img src="${imagePath}" 
                         alt="${product.product_name}" 
                         class="img-fluid" 
                         style="max-height: 250px; object-fit: contain;" />
                    <img class="hover-image img-fluid" 
                         src="${imagePath}" 
                         alt="${product.product_name}"
                         style="max-height: 250px; object-fit: contain;" />
                </a>
            </div>
            <div class="content flex-grow-1 d-flex flex-column">
                <span class="category">
                    <a href="#">${categoryName}</a>
                </span>
                <h5 class="title" style="min-height: 3rem;">
                    <a href="single-product.html" class="d-block" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; white-space: normal;">${productName}</a>
                </h5>
                <span class="price mt-auto">
                    ${hasDiscount ? `<span class="old text-muted text-decoration-line-through me-2">$${sellingPrice.toFixed(2)}</span>` : ''}
                    <span class="new fw-bold">$${finalPrice.toFixed(2)}</span>
                </span>
            </div>
            <div class="actions d-flex justify-content-center gap-2 mt-3">
                <button title="Add To Cart" class="action add-to-cart btn btn-sm" data-bs-toggle="modal"
                    data-bs-target="#exampleModal-Cart">
                    <i class="pe-7s-shopbag"></i>
                </button>
                <button class="action wishlist btn btn-sm" title="Wishlist" data-bs-toggle="modal"
                    data-bs-target="#exampleModal-Wishlist">
                    <i class="pe-7s-like"></i>
                </button>
                <button class="action quickview btn btn-sm" data-link-action="quickview" title="Quick view"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="pe-7s-look"></i>
                </button>
            </div>
        </div>
    </div>`;
    };

    const switchTab = (activeTab, activeButton) => {
        newArriveTab.classList.remove('show', 'active');
        specialOfferTab.classList.remove('show', 'active');
        featuredTab.classList.remove('show', 'active');

        buttons.forEach(btn => btn.classList.remove('active'));

        activeTab.classList.add('show', 'active');

        if (activeButton) {
            activeButton.classList.add('active');
        }
    }

    const NewArrival = () => {
        if (!productsData) return;

        let row = '';
        productsData.data.newArrival.forEach(product => {
            row += generateProductCard(product, 'new');
        });
        newArriveRow.innerHTML = row;

        switchTab(newArriveTab, buttons[0]);
    }

    const SpecialOffer = () => {
        if (!productsData) return;

        let row = '';
        productsData.data.specialOffer.forEach(product => {
            row += generateProductCard(product, 'special');
        });
        specialOfferRow.innerHTML = row;

        switchTab(specialOfferTab, buttons[1]);
    }

    const FeaturedProduct = () => {
        if (!productsData) return;

        let row = '';
        productsData.data.featured.forEach(product => {
            row += generateProductCard(product, 'featured');
        });
        featuredRow.innerHTML = row;

        switchTab(featuredTab, buttons[2]);
    }

    productData();
</script>
