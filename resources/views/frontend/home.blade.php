@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
@include('frontend.slider')

<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Sản Phẩm Nổi Bật
        </h3>
        <div class="row">
            <!-- product left -->
            <div class="agileinfo-ads-display col-lg-9">
                <div class="wrapper">
                    @foreach($categories as $category)
                    <div class="product-sec1 px-sm-4 px-3 py-sm-5 py-3 mb-4">
                        <h3 class="heading-tittle text-center">{{ $category->name }}</h3>
                        <div class="row">
                            @foreach($category->products()->where('status', 'active')->orderBy('id', 'desc')->limit(6)->get() as $product)
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
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- //product left -->

            <!-- product right -->
            <div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
                <div class="side-bar p-sm-4 p-3">
                    <div class="search-hotel border-bottom py-2">
                        <h3 class="agileits-sear-head mb-3">Tìm kiếm</h3>
                        <form action="{{ route('frontend.search') }}" method="get">
                            <input type="search" placeholder="Sản phẩm..." name="q" required>
                            <input type="submit" value=" ">
                        </form>
                    </div>
                    
                    <div class="range border-bottom py-2">
                        <h3 class="agileits-sear-head mb-3">Giá</h3>
                        <div class="w3l-range">
                            <ul>
                                <li><a href="{{ route('frontend.search', ['q' => '', 'price' => '0-1000000']) }}">Dưới 1 triệu</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="customer-rev border-bottom left-side py-2">
                        <h3 class="agileits-sear-head mb-3">Đánh giá khách hàng</h3>
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half"></i>
                                    <span>5.0</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="left-side border-bottom py-2">
                        <h3 class="agileits-sear-head mb-3">Danh mục sản phẩm</h3>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <input type="checkbox" class="checked">
                                <span class="span">
                                    <a href="{{ route('frontend.category', ['id' => $category->id]) }}">{{ $category->name }}</a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="f-grid py-2">
                        <h3 class="agileits-sear-head mb-3">Sản phẩm bán chạy</h3>
                        <div class="box-scroll">
                            <div class="scroll">
                                @foreach(\App\Models\Product::where('is_featured', true)->where('status', 'active')->limit(5)->get() as $product)
                                <div class="row p-2">
                                    <div class="col-lg-3 col-sm-2 col-3 left-mar">
                                        <img src="{{ $product->featured_image ? asset('images/' . $product->featured_image) : asset('images/products/default.jpg') }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid"
                                             onerror="this.src='{{ asset('images/products/default.jpg') }}'; this.onerror=null;">
                                    </div>
                                    <div class="col-lg-9 col-sm-10 col-9 w3_mvd">
                                        <a style="color: #333;" href="{{ route('frontend.product-detail', $product->id) }}">{{ $product->name }}</a><br>
                                        <a href="{{ route('frontend.product-detail', $product->id) }}" class="price-mar mt-2">{{ number_format($product->sale_price ?? $product->price) }}.đ</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //top products -->
@endsection

