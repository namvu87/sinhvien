@php
    $cartCount = auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->count() : 0;
@endphp

<!-- top-header -->
<div class="agile-main-top">
    <div class="container-fluid">
        <div class="row main-top-w3l py-2">
            <div class="col-lg-4 header-most-top">
                <p class="text-white text-lg-left text-center">Ưu đãi & Giảm giá hàng đầu
                    <i class="fas fa-shopping-cart ml-1"></i>
                </p>
            </div>
            <div class="col-lg-8 header-right mt-lg-0 mt-2">
                <ul>
                    <li class="text-center border-right text-white">
                        <a class="play-icon popup-with-zoom-anim text-white" href="#small-dialog1">
                            <i class="fas fa-map-marker mr-2"></i>Hệ thống</a>
                    </li>
                    @auth
                    <li class="text-center border-right text-white">
                        <a href="{{ route('frontend.orders') }}" class="text-white">
                            <i class="fas fa-truck mr-2"></i>Đơn mua</a>
                    </li>
                    @endauth
                    <li class="text-center border-right text-white">
                        <i class="fas fa-phone mr-2"></i> 0123456789
                    </li>
                    @guest
                    <li class="text-center border-right text-white">
                        <a href="#" data-toggle="modal" data-target="#loginModal" class="text-white">
                            <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập </a>
                    </li>
                    <li class="text-center text-white">
                        <a href="#" data-toggle="modal" data-target="#registerModal" class="text-white">
                            <i class="fas fa-sign-out-alt mr-2"></i>Đăng ký </a>
                    </li>
                    @else
                    <li class="text-center text-white">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link text-white p-0" style="text-decoration: none;">
                                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- shop locator (popup) -->
<div id="small-dialog1" class="mfp-hide">
    <div class="select-city">
        <h3>
            <i class="fas fa-map-marker"></i> Vui lòng chọn vị trí của bạn
        </h3>
        <select class="list_of_cities">
            <optgroup label="Popular Cities">
                <option selected style="display:none;color:#eee;">Chọn địa điểm</option>
                <option>TP. Hồ Chí Minh</option>
                <option>Hà Nội</option>
                <option>Đà Nẵng</option>
                <option>Cần Thơ</option>
            </optgroup>
        </select>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title text-center w-100">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(session('login_required'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-left: 4px solid #ffc107;">
                    <strong><i class="fas fa-exclamation-triangle"></i> Thông báo:</strong> 
                    Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng và mua hàng.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-form-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" class="form-control" placeholder="Nhập email của bạn" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                        <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" required>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('frontend.forgot-password') }}" class="text-danger">
                            <i class="fas fa-question-circle"></i> Quên mật khẩu?
                        </a>
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control btn btn-primary" value="Đăng nhập" style="font-weight: bold;">
                    </div>
                    <p class="text-center dont-do mt-3">Bạn chưa có tài khoản?
                        <a href="#" data-toggle="modal" data-target="#registerModal" data-dismiss="modal" style="color: #667eea; font-weight: bold;">
                            <i class="fas fa-user-plus"></i> Đăng ký ngay
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đăng ký</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="col-form-label">Họ tên</label>
                        <input type="text" class="form-control" placeholder=" " name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control" placeholder=" " name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder=" " name="phone" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Địa chỉ</label>
                        <input type="text" class="form-control" placeholder=" " name="address" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mật khẩu</label>
                        <input type="password" class="form-control" placeholder=" " name="password" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" placeholder=" " name="password_confirmation" required>
                    </div>
                    <div class="right-w3l">
                        <input type="submit" class="form-control" value="Đăng ký">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- header-bottom-->
<div class="header-bot">
    <div class="container">
        <div class="row header-bot_inner_wthreeinfo_header_mid d-flex align-items-center justify-content-between">
            <!-- logo -->
            <div class="col-md-3 logo_agile">
                <a class="text-center" href="{{ route('frontend.home') }}">
                    <img src="{{ asset('images/logo_fruit.png') }}" style="z-index: 1000;" class="img-fluid" alt="">
                </a>
            </div>
            <!-- //logo -->
            <!-- header-bot -->
            <div class="col-md-9 header mt-4 mb-md-0 mb-5">
                <div class="row d-flex align-items-center">
                    <!-- search -->
                    <div class="col-9 agileits_search">
                        <form class="form-inline" action="{{ route('frontend.search') }}" method="get">
                            <input class="form-control mr-sm-2" name="q" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" required>
                            <button class="btn my-2 my-sm-0" type="submit">Tìm kiếm</button>
                        </form>
                    </div>
                    <!-- //search -->
                    <!-- cart details -->
                    <div class="col-1 top_nav_right text-center mt-sm-0 mt-2">
                        <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                            <form action="{{ route('frontend.cart') }}" method="get">
                                <button class="btn w3view-cart" type="submit">
                                    <i class="fas fa-cart-arrow-down position-relative">
                                        <span class="position-absolute quantity_cart">{{ $cartCount }}</span>
                                    </i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- user dropdown -->
                    <div class="col-1 dropdown top_nav_right mt-sm-0 mt-2">
                        @auth
                        <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">	
                            <div class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle d-flex align-items-center rounded" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle" src="{{ asset('images/user1.png') }}" width="40px">
                                    <span class="mx-2 d-none d-lg-inline text-gray-600" style="color: #111;">
                                        {{ strstr(auth()->user()->email, '@', true) ?: 'USER' }}
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('frontend.profile') }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Hồ sơ
                                    </a>
                                    <a class="dropdown-item" href="{{ route('frontend.orders') }}">
                                        <i class="fas fa-truck fa-sm fa-fw mr-2 text-gray-400"></i> 
                                        Đơn mua
                                    </a>
                                    <a class="dropdown-item" href="{{ route('frontend.checkout') }}">
                                        <i class="fas fa-credit-card fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Thanh toán
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </nav>	
                        @else
                        <button class="btn w3view-cart" onclick="alert('Vui lòng đăng nhập trước khi sử dụng chức năng này.');">
                            <i class="fas fa-user"></i>
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //header-bottom -->

