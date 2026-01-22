@php
    $categories = \App\Models\Category::where('status', 'active')->orderBy('display_order')->get();
@endphp

<div class="navbar-inner">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="agileits-navi_search">
                <form action="{{ route('frontend.category') }}" method="get" id="categoryForm">
                    <select id="agileinfo-nav_search" name="id" class="border" onchange="document.getElementById('categoryForm').submit();">
                        <option value="">Danh mục sản phẩm</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center mr-xl-5">
                    <li class="nav-item active mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.home') }}">Trang chủ
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.category', ['id' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.products.new') }}">Sản phẩm mới</a>
                    </li>
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.products.bestsellers') }}">Bán chạy</a>
                    </li>
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.products.discounted') }}">Giảm giá</a>
                    </li>
                    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="{{ route('frontend.about') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.contact') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- //navigation -->

