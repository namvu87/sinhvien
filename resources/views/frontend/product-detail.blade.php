@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="{{ route('frontend.home') }}">Trang chủ</a>
                    <i>|</i>
                </li>
                <li>Chi tiết sản phẩm</li>
            </ul>
        </div>
    </div>
</div>

<!-- Single Page -->
<div class="banner-bootom-w3-agileits py-5">
    <div class="container py-xl-4 py-lg-2">
        <div class="row">
            <div class="col-lg-5 col-md-8 single-right-left">
                <div class="grid images_3_of_2">
                    <div class="flexslider">
                        <ul class="slides">
                            <li data-thumb="{{ $product->featured_image ? asset('images/' . $product->featured_image) : asset('images/products/default.jpg') }}">
                                <div class="thumb-image">
                                    <img src="{{ $product->featured_image ? asset('images/' . $product->featured_image) : asset('images/products/default.jpg') }}" 
                                         data-imagezoom="true" 
                                         class="img-fluid" 
                                         alt="{{ $product->name }}"
                                         onerror="this.src='{{ asset('images/products/default.jpg') }}'; this.onerror=null;">
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 single-right-left simpleCart_shelfItem">
                <h2 class="mb-1">{{ $product->name }}</h2>
                <p class="mb-1">
                    <span class="item_price2">{{ number_format($product->sale_price ?? $product->price) }}đ</span>
                    @if($product->sale_price)
                    <del class="del2 mx-2 font-weight-light">{{ number_format($product->price) }}đ</del>
                    @endif
                    <label>Giao hàng miễn phí</label>
                </p>
                <div class="product-single-w3l">
                    <p class="my-3">
                        {{ $product->short_description }}
                    </p>
                    <p class="my-3">
                        {!! nl2br(e($product->description)) !!}
                    </p>
                </div>
                <div class="occasion-cart">
                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        <form action="{{ route('frontend.cart.add') }}" method="post">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                <div class="d-flex">
                                    <input type="number" name="quantity" class="p-1 mr-2" style="width: 40px;" min="1" value="1">
                                    <input type="submit" value="Thêm vào giỏ" class="button mr-2" />
                                    <a href="{{ route('frontend.checkout') }}" class="button-buy">Mua ngay</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //Single Page -->

@include('frontend.similar-products', ['category' => $product->category, 'productId' => $product->id])
@endsection

