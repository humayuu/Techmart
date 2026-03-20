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
                                    <th>Price</th>
                                    <th>Add To Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wishlist as $key => $list)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="/product/detail/{{ $list['product_id'] }}">
                                                <img class="img-responsive ml-15px" src="{{ asset($list['image']) }}"
                                                    alt="{{ $list['product_name'] }}" />
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="/product/detail/{{ $list['product_id'] }}">
                                                {{ $list['product_name'] }}
                                            </a>
                                        </td>
                                        <td class="product-price-cart">
                                            <span class="amount">Rs. {{ $list['price'] }}</span>
                                        </td>
                                        <td class="product-wishlist-cart">
                                            <button onclick="AddToCart({{ $list['product_id'] }})">
                                                Add to Cart
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center fs-5 text-danger p-4">
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
