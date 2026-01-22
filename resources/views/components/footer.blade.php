<!-- footer -->
<footer>
    <div class="footer-top-first">
        <div class="container py-md-5 py-sm-4 py-3">
            <div class="row w3l-grids-footer border-top border-bottom py-sm-4 py-3">
                <div class="col-md-4 offer-footer">
                    <div class="row"> 
                        <div class="col-4 icon-fot">
                            <i class="fas fa-dolly"></i>
                        </div>
                        <div class="col-8 text-form-footer">
                            <h3>Miễn phí vận chuyển</h3>
                            <p>Đơn hàng trên 1 triệu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 offer-footer my-md-0 my-4">
                    <div class="row">
                        <div class="col-4 icon-fot">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="col-8 text-form-footer">
                            <h3>Chuyển phát nhanh</h3>
                            <p>Trên khắp Việt Nam</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 offer-footer">
                    <div class="row">
                        <div class="col-4 icon-fot">
                            <i class="far fa-thumbs-up"></i>
                        </div>
                        <div class="col-8 text-form-footer">
                            <h3>Lựa chọn</h3>
                            <p>Nhiều sản phẩm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="w3l-middlefooter-sec">
        <div class="container py-md-5 py-sm-4 py-3">
            <div class="row footer-info w3l-agileits-info">
                <div class="col-md-3 col-sm-6 footer-grids">
                    <h3 class="text-white font-weight-bold mb-3">Danh mục</h3>
                    <ul>
                        @php
                            $footerCategories = \App\Models\Category::where('status', 'active')->limit(4)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                        <li class="mb-3">
                            <a href="{{ route('frontend.category', ['id' => $category->id]) }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-md-3 col-sm-6 footer-grids mt-sm-0 mt-4">
                    <h3 class="text-white font-weight-bold mb-3">Đường dẫn</h3>
                    <ul>
                        <li class="mb-3">
                            <a href="{{ route('frontend.about') }}">Về chúng tôi</a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('frontend.contact') }}">Liên hệ chúng tôi</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Hỗ trợ</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Câu hỏi thường gặp</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">Điều khoản</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-3 col-sm-6 footer-grids mt-md-0 mt-4">
                    <h3 class="text-white font-weight-bold mb-3">Liên hệ</h3>
                    <ul>
                        <li class="mb-3">
                            <i class="fas fa-map-marker"></i> Mỹ Tân, TP Nam Định, Nam Định
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-mobile"></i> 333 222 3333
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone"></i> 03 6666 8888
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope-open"></i>
                            <a href="mailto:example@mail.com">pitustore@gmail.com</a>
                        </li>
                        <li>
                            <i class="fas fa-envelope-open"></i>
                            <a href="mailto:example@mail.com">pitushop@gmail.com</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-3 col-sm-6 footer-grids w3l-agileits mt-md-0 mt-4">
                    <h3 class="text-white font-weight-bold mb-3">Bản tin</h3>
                    <p class="mb-3">Giao hàng miễn phí cho đơn hàng đầu tiên của bạn!</p>
                    <form action="#" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                            <input type="submit" value="Gửi">
                        </div>
                    </form>
                    <div class="footer-grids w3l-socialmk mt-3">
                        <h3 class="text-white font-weight-bold mb-3">Theo dõi chúng tôi</h3>
                        <div class="social">
                            <ul>
                                <li>
                                    <a class="icon fb" href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="icon tw" href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="icon gp" href="#">
                                        <i class="fab fa-google-plus-g"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="copy-right py-3">
    <div class="container">
        <p class="text-center text-white">© 2025 0123456789. Bản quyền | 0123456789
            <a href="#"></a>
        </p>
    </div>
</div>
<!-- //footer -->

