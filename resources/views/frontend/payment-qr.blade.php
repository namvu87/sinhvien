@extends('layouts.app')

@section('title', 'Thanh toán QR Code')

@section('content')
<style>
    .qr-container {
        text-align: center;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin: 20px 0;
    }
    .qr-code-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 20px 0;
    }
    .qr-code-wrapper img {
        max-width: 300px;
        height: auto;
        border: 3px solid #f0f0f0;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
    }
    .bank-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #333;
    }
    .info-value {
        color: #666;
    }
    .amount-highlight {
        font-size: 24px;
        font-weight: bold;
        color: #dc3545;
        margin: 20px 0;
    }
</style>

<section style="background-color: #eee; min-height: 80vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-check-circle"></i> Đặt hàng thành công!
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Mã đơn hàng: <strong>{{ $orderCode }}</strong></h5>
                            <div class="amount-highlight">
                                Tổng tiền: {{ number_format($totalAmount, 0, ',', '.') }}đ
                            </div>
                        </div>

                        <hr>

                        <div class="qr-container">
                            <h5 class="mb-3">Quét mã QR để thanh toán</h5>
                            <div class="qr-code-wrapper" style="display: flex; justify-content: center; align-items: center; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <div style="text-align: center;">
                                    <!-- Hiển thị QR code dạng PNG (base64) -->
                                    <img src="data:image/png;base64,{{ $qrData['qr_code_base64'] }}" 
                                         alt="QR Code Thanh toán" 
                                         style="max-width: 300px; height: auto; border: 3px solid #f0f0f0; border-radius: 8px; padding: 10px; background: #fff;">
                                    <p class="mt-3 text-muted">
                                        <i class="fas fa-mobile-alt"></i> Sử dụng app ngân hàng để quét mã QR này
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button onclick="downloadQR()" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> Tải mã QR
                                </button>
                                <button onclick="copyQRInfo()" class="btn btn-sm btn-outline-secondary ml-2">
                                    <i class="fas fa-copy"></i> Sao chép thông tin
                                </button>
                            </div>
                        </div>
                        
                        <script>
                            function downloadQR() {
                                const link = document.createElement('a');
                                link.href = 'data:image/png;base64,{{ $qrData['qr_code_base64'] }}';
                                link.download = 'QR-{{ $orderCode }}.png';
                                link.click();
                            }
                            
                            function copyQRInfo() {
                                const info = `Số tài khoản: {{ $bankInfo['account_number'] }}\nChủ tài khoản: {{ $bankInfo['account_holder'] }}\nSố tiền: {{ number_format($totalAmount, 0, ',', '.') }}đ\nNội dung: {{ $orderCode }}`;
                                navigator.clipboard.writeText(info).then(function() {
                                    alert('Đã sao chép thông tin thanh toán!');
                                }, function() {
                                    // Fallback cho trình duyệt không hỗ trợ clipboard API
                                    const textarea = document.createElement('textarea');
                                    textarea.value = info;
                                    document.body.appendChild(textarea);
                                    textarea.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(textarea);
                                    alert('Đã sao chép thông tin thanh toán!');
                                });
                            }
                        </script>

                        <div class="bank-info">
                            <h5 class="mb-3">
                                <i class="fas fa-university"></i> Thông tin tài khoản ngân hàng
                            </h5>
                            <div class="info-item">
                                <span class="info-label">Ngân hàng:</span>
                                <span class="info-value">{{ $bankInfo['bank_name'] }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Số tài khoản:</span>
                                <span class="info-value"><strong>{{ $bankInfo['account_number'] }}</strong></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Chủ tài khoản:</span>
                                <span class="info-value">{{ $bankInfo['account_holder'] }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Chi nhánh:</span>
                                <span class="info-value">{{ $bankInfo['branch'] }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Số tiền:</span>
                                <span class="info-value"><strong class="text-danger">{{ number_format($totalAmount, 0, ',', '.') }}đ</strong></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nội dung chuyển khoản:</span>
                                <span class="info-value"><strong>{{ $orderCode }}</strong></span>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <h6><i class="fas fa-exclamation-triangle"></i> Lưu ý quan trọng:</h6>
                            <ul class="mb-0">
                                <li>Vui lòng chuyển khoản đúng số tiền: <strong>{{ number_format($totalAmount, 0, ',', '.') }}đ</strong></li>
                                <li>Nội dung chuyển khoản phải ghi: <strong>{{ $orderCode }}</strong></li>
                                <li>Sau khi chuyển khoản, vui lòng chụp ảnh biên lai và gửi cho chúng tôi</li>
                                <li>Đơn hàng sẽ được xử lý sau khi xác nhận thanh toán thành công</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('frontend.orders') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> Xem đơn hàng của tôi
                            </a>
                            <a href="{{ route('frontend.home') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Về trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
