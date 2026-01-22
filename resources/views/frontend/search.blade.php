@extends('layouts.app')

@section('title', 'Tìm kiếm: ' . request('q'))

@section('content')
<div class="ads-grid py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h5 class="tittle-w3l text-center text-dark mb-lg-5 mb-sm-4 mb-3">
            Kết quả tìm kiếm sản phẩm: {{ request('q') }}
        </h5>
        <div class="row">
            <div class="agileinfo-ads-display col-lg-9">
                <div class="wrapper">
                    <div class="product-sec1 px-sm-4 px-3 py-sm-5 py-3 mb-4">
                        <div class="row">
                            @forelse($products as $product)
                            <div class="col-md-4 product-men mt-5">
                                <div class="men-pro-item simpleCart_shelfItem">
                                    <div class="men-thumb-item text-center">
                                        <img src="{{ $product->featured_image ? asset('images/' . $product->featured_image) : asset('images/products/default.jpg') }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid"
                                             onerror="this.src='{{ asset('images/products/default.jpg') }}'; this.onerror=null;">
                                        <div class="men-cart-pro">
                                            <div class="inner-men-cart-pro">
                                                <a href="{{ route('frontend.product-detail', $product->id) }}" class="link-product-add-cart">Xem sản phẩm</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info-product text-center border-top mt-4">
                                        <h4 class="pt-1">
                                            <a href="{{ route('frontend.product-detail', $product->id) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <div class="info-product-price my-2">
                                            <span class="item_price">{{ number_format($product->sale_price ?? $product->price) }}.đ</span>
                                            @if($product->sale_price)
                                            <del>{{ number_format($product->price) }}.đ</del>
                                            @endif
                                        </div>
                                        <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                            <form action="{{ route('frontend.cart.add') }}" method="post">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                    <input type="hidden" name="quantity" value="1"/>
                                                    <input type="submit" value="Thêm vào giỏ" class="button" />
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Không tìm thấy sản phẩm nào với từ khóa "{{ request('q') }}".</p>
                                <a href="{{ route('frontend.home') }}" class="btn btn-primary">Quay về trang chủ</a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

