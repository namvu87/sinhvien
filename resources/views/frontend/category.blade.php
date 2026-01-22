@extends('layouts.app')

@section('title', isset($category) && $category ? $category->name : (isset($title) ? $title : 'Danh mục sản phẩm'))

@section('content')
<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            {{ isset($title) ? $title : (isset($category) && $category ? $category->name : 'Tất cả sản phẩm') }}
        </h3>
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
                                <p class="text-muted">Không có sản phẩm nào trong danh mục này.</p>
                            </div>
                            @endforelse
                        </div>
                        
                        @if($products->hasPages())
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 mt-lg-0 mt-4 p-lg-0">
                <div class="side-bar p-sm-4 p-3">
                    <div class="search-hotel border-bottom py-2">
                        <h3 class="agileits-sear-head mb-3">Các loại sản phẩm</h3>
                        <form action="{{ route('frontend.search') }}" method="get">
                            <input type="search" placeholder="Tìm kiếm" name="q" required>
                            <input type="submit" value=" ">
                        </form>
                        <div class="left-side py-2">
                            <ul>
                                @foreach(\App\Models\Category::where('status', 'active')->get() as $cat)
                                <li>
                                    <input type="checkbox" class="checked">
                                    <span class="span">
                                        <a href="{{ route('frontend.category', ['id' => $cat->id]) }}">{{ $cat->name }}</a>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //top products -->
@endsection

