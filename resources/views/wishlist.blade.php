@extends('layout')
@section('main')
    <div class="cart-main-area pt-100px pb-100px">
        <div class="container">
            <h3 class="cart-page-title">Your Wishlist</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Add To Cart</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody id="wishlist-page-tbody">
                                @forelse ($wishlist as $key => $list)
                                    <tr data-wishlist-row data-product-id="{{ $list['product_id'] }}">
                                        <td class="product-thumbnail">
                                            <a href="/product/detail/{{ $list['product_id'] }}">
                                                <img class="img-responsive ml-15px" src="{{ asset('images/products/thumbnail/' . $list['image']) }}"
                                                    alt="{{ $list['product_name'] }}" />
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="/product/detail/{{ $list['product_id'] }}">
                                                {{ $list['product_name'] }}
                                            </a>
                                        </td>
                                        <td class="product-category">
                                            {{ $list['category_name'] ?? '' }}
                                        </td>
                                        <td class="product-brand">
                                            {{ $list['brand_name'] ?? '' }}
                                        </td>
                                        <td class="product-price-cart">
                                            <span class="amount">Rs. {{ number_format((float) ($list['price'] ?? 0), 2) }}</span>
                                        </td>
                                        <td class="product-wishlist-cart">
                                            <a href="javascript:void(0)"
                                                onclick="AddToCart({{ $list['product_id'] }}); return false;">Add to Cart</a>
                                        </td>
                                        <td class="product-remove">
                                            <a href="#"
                                                class="wishlist-page-remove"
                                                data-wishlist-page-remove="{{ $list['product_id'] }}"
                                                title="Remove from wishlist"
                                                aria-label="Remove from wishlist">×</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="wishlist-empty-placeholder">
                                        <td colspan="7" class="text-center text-danger p-4">
                                            Your wishlist is empty.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
