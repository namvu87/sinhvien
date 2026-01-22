<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function showQR($orderCode)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }
        
        // Lấy đơn hàng theo order_code
        $order = Order::where('order_code', $orderCode)
            ->with(['customer', 'product'])
            ->first();
        
        if (!$order) {
            return redirect()->route('frontend.home')->with('error', 'Đơn hàng không tồn tại');
        }
        
        // Kiểm tra đơn hàng thuộc về user hiện tại
        $customer = $order->customer;
        $user = auth()->user();
        
        if ($customer->user_code != $user->user_code) {
            return redirect()->route('frontend.home')->with('error', 'Bạn không có quyền xem đơn hàng này');
        }
        
        // Tính tổng tiền từ các đơn hàng cùng order_code
        $orders = Order::where('order_code', $orderCode)->get();
        $totalAmount = $orders->sum('total_revenue');
        
        // Tạo dữ liệu QR code (thông tin ngân hàng - có thể lưu trong config hoặc database)
        $bankInfo = [
            'bank_name' => 'Vietcombank',
            'account_number' => '1234567890',
            'account_holder' => 'CONG TY TNHH ABC',
            'branch' => 'Chi nhánh TP.HCM',
        ];
        
        // Tạo nội dung chuyển khoản
        $transferContent = $orderCode;
        
        // Tạo chuỗi dữ liệu cho QR code
        // Format đơn giản: Số tài khoản|Tên người nhận|Số tiền|Nội dung
        // Hoặc có thể dùng format VietQR nếu cần
        $qrString = sprintf(
            "%s|%s|%.0f|%s",
            $bankInfo['account_number'],
            $bankInfo['account_holder'],
            $totalAmount,
            $transferContent
        );
        
        // Tạo mã QR code dạng PNG (base64 để embed trực tiếp vào HTML)
        $qrCodeBase64 = base64_encode(
            QrCode::size(300)
                ->format('png')
                ->errorCorrection('H') // Mức độ sửa lỗi cao
                ->generate($qrString)
        );
        
        $qrData = [
            'account_number' => $bankInfo['account_number'],
            'amount' => $totalAmount,
            'content' => $transferContent,
            'qr_string' => $qrString,
            'qr_code_base64' => $qrCodeBase64,
        ];
        
        return view('frontend.payment-qr', compact('order', 'orders', 'totalAmount', 'bankInfo', 'qrData', 'orderCode'));
    }
}
