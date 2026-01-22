@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span class="sub-tittle">Về chúng tôi</span>
            Giới thiệu
        </h3>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Giới thiệu chính -->
                <div class="about-content mb-5">
                    <h4 class="mb-4 text-center" style="color: #28a745; font-weight: bold;">
                        Chào mừng đến với Halona Fruits
                    </h4>
                    <p class="lead text-center mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        Halona Fruits là cửa hàng trái cây và đồ uống tươi ngon hàng đầu, chuyên cung cấp các sản phẩm trái cây nhập khẩu cao cấp, trái cây nội địa tươi ngon và các loại đồ uống tự nhiên, đảm bảo chất lượng và an toàn vệ sinh thực phẩm.
                    </p>
                </div>

                <!-- Sứ mệnh -->
                <div class="mission-section mb-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3" style="color: #28a745;">
                                <i class="fas fa-bullseye mr-2"></i>Sứ mệnh của chúng tôi
                            </h5>
                            <p class="card-text" style="line-height: 1.8;">
                                Chúng tôi cam kết mang đến cho khách hàng những sản phẩm trái cây và đồ uống tươi ngon nhất, 
                                được chọn lọc kỹ càng từ các nguồn cung cấp uy tín. Với phương châm "Sức khỏe từ thiên nhiên", 
                                Halona Fruits luôn đặt chất lượng và sự hài lòng của khách hàng lên hàng đầu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Giá trị cốt lõi -->
                <div class="values-section mb-5">
                    <h5 class="mb-4 text-center" style="color: #28a745;">
                        <i class="fas fa-heart mr-2"></i>Giá trị cốt lõi
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3" style="background: #f8f9fa; border-radius: 10px; height: 100%;">
                                <i class="fas fa-check-circle fa-3x mb-3" style="color: #28a745;"></i>
                                <h6 class="font-weight-bold">Chất lượng</h6>
                                <p class="small mb-0">Sản phẩm tươi ngon, đảm bảo an toàn vệ sinh thực phẩm</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3" style="background: #f8f9fa; border-radius: 10px; height: 100%;">
                                <i class="fas fa-handshake fa-3x mb-3" style="color: #28a745;"></i>
                                <h6 class="font-weight-bold">Uy tín</h6>
                                <p class="small mb-0">Cam kết đúng chất lượng, đúng giá trị như đã cam kết</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-center p-3" style="background: #f8f9fa; border-radius: 10px; height: 100%;">
                                <i class="fas fa-smile fa-3x mb-3" style="color: #28a745;"></i>
                                <h6 class="font-weight-bold">Hài lòng</h6>
                                <p class="small mb-0">Dịch vụ chăm sóc khách hàng tận tâm, chu đáo</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sản phẩm -->
                <div class="products-section mb-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3" style="color: #28a745;">
                                <i class="fas fa-shopping-basket mr-2"></i>Sản phẩm của chúng tôi
                            </h5>
                            <ul class="list-unstyled" style="line-height: 2;">
                                <li><i class="fas fa-check text-success mr-2"></i><strong>Trái cây nhập khẩu:</strong> Cherry Mỹ, Kiwi Úc, Táo Envy New Zealand, Nho Hàn Quốc và nhiều loại trái cây cao cấp khác</li>
                                <li><i class="fas fa-check text-success mr-2"></i><strong>Trái cây nội địa:</strong> Măng cụt Bảo Lộc, Thanh long ruột trắng, và các loại trái cây đặc sản Việt Nam</li>
                                <li><i class="fas fa-check text-success mr-2"></i><strong>Đồ uống tự nhiên:</strong> Nước ép trái cây tươi, sinh tố tự nhiên, không chất bảo quản</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Dịch vụ -->
                <div class="services-section mb-5">
                    <h5 class="mb-4 text-center" style="color: #28a745;">
                        <i class="fas fa-concierge-bell mr-2"></i>Dịch vụ của chúng tôi
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fas fa-truck fa-2x" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Giao hàng nhanh</h6>
                                    <p class="small mb-0">Miễn phí vận chuyển cho đơn hàng trên 1 triệu đồng. Giao hàng tận nơi trên toàn quốc.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fas fa-shield-alt fa-2x" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Đảm bảo chất lượng</h6>
                                    <p class="small mb-0">Tất cả sản phẩm đều được kiểm tra kỹ lưỡng trước khi giao đến tay khách hàng.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fas fa-headset fa-2x" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Hỗ trợ 24/7</h6>
                                    <p class="small mb-0">Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fas fa-undo fa-2x" style="color: #28a745;"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold">Đổi trả dễ dàng</h6>
                                    <p class="small mb-0">Chính sách đổi trả linh hoạt nếu sản phẩm không đúng như mô tả.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liên hệ -->
                <div class="contact-section text-center">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3" style="color: #28a745;">
                                <i class="fas fa-envelope mr-2"></i>Liên hệ với chúng tôi
                            </h5>
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <strong>Địa chỉ:</strong> Mỹ Tân, TP Nam Định, Nam Định
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone mr-2"></i>
                                <strong>Hotline:</strong> 0123456789 | 333 222 3333
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-clock mr-2"></i>
                                <strong>Giờ làm việc:</strong> 8:00 - 20:00 (Tất cả các ngày trong tuần)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

