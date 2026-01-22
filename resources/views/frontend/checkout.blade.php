@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
@php
    $user = auth()->user();
    // $cartItems, $total, $bankInfo, $qrCodeBase64 đã được truyền từ controller
@endphp

<style>
    .f-family {
        font-family: 'Roboto', sans-serif;
    }
    .product-list-payment {
        max-height: 200px;
        overflow-y: auto;
    }
    .fw-500 {
        font-weight: 500;
    }
</style>

<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-center pb-5">
                    <div class="col-md-6 col-xl-5 mb-4 mb-md-0">
                        <div class="py-4 d-flex flex-row">
                            <h5><span class="far fa-check-square pe-2"></span> <b>Thanh toán</b> </h5>
                        </div>
                        <p class="text-left">
                            <span class="text-danger">Tên: </span><span class="text-dark">{{ $user->name }}</span><br>
                            <span class="text-danger"> Địa chỉ:</span><span class="text-dark"> {{ $user->address }}</span><br>
                            <span class="text-danger">Phone: </span><span class="text-dark">{{ $user->phone }}</span>
                        </p>
                        <p class="text-left">
                            <i class="fas fa-plus-circle text-primary pe-1"></i>
                            <a href="{{ route('frontend.profile') }}">Thay đổi</a>
                        </p>
                        <hr />
                        <div class="pt-2">
                            <form action="{{ route('frontend.checkout.process') }}" method="post">
                                @csrf
                                <input type="hidden" name="name" value="{{ $user->name }}">  
                                <input type="hidden" name="phone" value="{{ $user->phone }}">   
                                <input type="hidden" name="email" value="{{ $user->email }}">  
                                <input type="hidden" name="address" value="{{ $user->address }}">
                                
                                @foreach($cartItems as $item)
                                <input type="hidden" name="product_ids[]" value="{{ $item->product_id }}">
                                <input type="hidden" name="quantities[]" value="{{ $item->product_quantity }}">
                                @endforeach
                                
                                <div class="controls form-group">
                                    <label>Phương thức thanh toán <span class="text-danger">*</span></label>
                                    <select class="form-control rounded" name="payments" id="paymentMethod" required onchange="toggleQRCode()">
                                        <option value="">Chọn loại hình thức thanh toán</option>
                                        <option value="1">Thanh toán ATM</option>
                                        <option value="0">Thanh toán khi nhận hàng</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea class="form-control" name="note" rows="3"></textarea>
                                </div>
                                
                                <div class="pt-2">
                                    <button type="submit" name="thanhtoan" class="btn btn-primary btn-lg btn-block">
                                        <i class="fas fa-lock"></i> Đặt hàng
                                    </button>
                                </div>
                                
                                <script>
                                    function toggleQRCode() {
                                        const paymentMethod = document.getElementById('paymentMethod').value;
                                        const qrSection = document.getElementById('qrCodeSection');
                                        
                                        if (paymentMethod === '1') {
                                            qrSection.style.display = 'block';
                                        } else {
                                            qrSection.style.display = 'none';
                                        }
                                    }
                                    
                                    // Kiểm tra khi trang load xong
                                    document.addEventListener('DOMContentLoaded', function() {
                                        toggleQRCode();
                                    });
                                </script>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-xl-4">
                        <div class="py-4 d-flex flex-row">
                            <h5><span class="far fa-file-alt pe-2"></span> <b>Đơn hàng</b> </h5>
                        </div>
                        <div class="product-list-payment">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <p class="fw-500 mb-0">{{ $item->product_name }}</p>
                                    <p class="text-muted mb-0">Số lượng: {{ $item->product_quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="fw-500 mb-0">{{ number_format($item->product_quantity * $item->product_price) }}đ</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between">
                            <span class="fw-500">Tổng tiền:</span>
                            <span class="fw-500 text-danger">{{ number_format($total) }}đ</span>
                        </div>
                        
                        <!-- QR Code Section - Hiển thị bên phải khi chọn ATM -->
                        <div id="qrCodeSection" style="display: none; margin-top: 20px; animation: fadeIn 0.3s;">
                            <div class="card shadow-sm" style="border: 2px solid #007bff; border-radius: 10px;">
                                <div class="card-body text-center">
                                    <h6 class="mb-2 text-primary" style="font-size: 14px;">
                                        <i class="fas fa-qrcode"></i> Quét mã QR
                                    </h6>
                                    @if($qrCodeBase64)
                                    <div style="padding: 10px; background: #fff; border-radius: 8px; display: inline-block;">
                                        <img src="data:image/png;base64,{{ $qrCodeBase64 }}" 
                                             alt="QR Code Thanh toán" 
                                             style="max-width: 180px; height: auto; border: 2px solid #f0f0f0; border-radius: 8px; padding: 8px; background: #fff;">
                                    </div>
                                    @elseif($qrCodeSvg ?? null)
                                    <div style="padding: 10px; background: #fff; border-radius: 8px; display: inline-block;">
                                        <div style="max-width: 180px; margin: 0 auto; border: 2px solid #f0f0f0; border-radius: 8px; padding: 8px; background: #fff;">
                                            {!! $qrCodeSvg !!}
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-warning" style="font-size: 12px; padding: 8px;">
                                        <i class="fas fa-exclamation-triangle"></i> Không thể tạo mã QR code.
                                    </div>
                                    @endif
                                    <div class="mt-2" style="background: #f8f9fa; padding: 10px; border-radius: 8px; text-align: left; border-left: 3px solid #007bff; font-size: 12px;">
                                        <p class="mb-1"><strong>Ngân hàng:</strong> {{ $bankInfo['bank_name'] }}</p>
                                        <p class="mb-1"><strong>STK:</strong> <span class="text-danger">{{ $bankInfo['account_number'] }}</span></p>
                                        <p class="mb-1"><strong>Chủ TK:</strong> {{ $bankInfo['account_holder'] }}</p>
                                        <p class="mb-0"><strong>Số tiền:</strong> <span class="text-danger font-weight-bold">{{ number_format($total, 0, ',', '.') }}đ</span></p>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0" style="font-size: 11px;">
                                        <i class="fas fa-info-circle"></i> Quét mã QR để thanh toán
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <style>
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(-10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                </style>
            </div>
        </div>
    </div>
</section>
@endsection

