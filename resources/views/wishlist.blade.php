@extends('layout')
@section('main')
    <!-- Wishlist Area Start -->
    <div class="cart-main-area pt-100px pb-100px">
        <div class="container">
            <h3 class="cart-page-title">Your Wishlist</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <form action="#">
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
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="#"><img class="img-responsive ml-15px"
                                                    src="assets/images/product-image/1.webp" alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">Modern Smart Phone</a></td>
                                        <td class="product-price-cart"><span class="amount">Rs. 60.00</span></td>
                                        <td class="product-wishlist-cart">
                                            <a href="#">add to cart</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Wishlist Area End -->
@endsection
