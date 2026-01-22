<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }
        
        $cartItems = Cart::where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Giỏ hàng của bạn đang trống');
        }
        
        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product_quantity * $item->product_price;
        }
        
        // Thông tin ngân hàng (có thể lưu trong config hoặc database)
        $bankInfo = [
            'bank_name' => 'Vietcombank',
            'account_number' => '1234567890',
            'account_holder' => 'CONG TY TNHH ABC',
            'branch' => 'Chi nhánh TP.HCM',
        ];
        
        // Tạo QR code tạm thời với thông tin thanh toán
        $qrCodeBase64 = null;
        $qrCodeSvg = null;
        
        try {
            $qrString = sprintf(
                "%s|%s|%.0f|THANHTOAN",
                $bankInfo['account_number'],
                $bankInfo['account_holder'],
                $total
            );
            
            // Thử tạo QR code dạng PNG trước (kích thước nhỏ hơn: 180px)
            try {
                $qrCode = QrCode::size(180)
                    ->format('png')
                    ->errorCorrection('H')
                    ->generate($qrString);
                
                $qrCodeBase64 = base64_encode($qrCode);
            } catch (\Exception $pngException) {
                // Nếu PNG không hoạt động, dùng SVG
                \Log::warning('PNG QR Code generation failed, using SVG: ' . $pngException->getMessage());
                $qrCodeSvg = QrCode::size(180)
                    ->errorCorrection('H')
                    ->generate($qrString);
            }
        } catch (\Exception $e) {
            // Nếu có lỗi khi tạo QR code, log lỗi và tiếp tục (không hiển thị QR)
            \Log::error('QR Code generation error: ' . $e->getMessage());
            $qrCodeBase64 = null;
            $qrCodeSvg = null;
        }
        
        return view('frontend.checkout', compact('cartItems', 'total', 'bankInfo', 'qrCodeBase64', 'qrCodeSvg'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'payments' => 'required',
            'product_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);
        
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $userCode = $user->user_code ?? rand(1000, 9999);
            
            // Tạo customer
            $customer = Customer::create([
                'customer_name' => $request->name,
                'user_code' => $userCode,
                'customer_phone' => $request->phone,
                'customer_email' => $request->email,
                'customer_address' => $request->address,
                'payments' => $request->payments,
                'customer_note' => $request->note,
            ]);
            
            // Cập nhật user_code cho user
            if ($user->user_code == 0 || !$user->user_code) {
                $user->user_code = $userCode;
                $user->save();
            }
            
            // Tính tổng tiền và kiểm tra tồn kho
            $cartItems = Cart::where('user_id', auth()->id())->get();
            $totalPayment = 0;
            
            // Kiểm tra tồn kho trước khi đặt hàng
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại');
                }
                if ($product->quantity < $item->product_quantity) {
                    throw new \Exception('Sản phẩm "' . $product->name . '" không đủ số lượng. Tồn kho: ' . $product->quantity);
                }
                $totalPayment += $item->product_quantity * $item->product_price;
            }
            
            // Tạo orders và transactions
            $orderCode = 'DH' . now()->format('Ymd') . rand(1000, 9999);
            $orderDate = now()->format('Y-m-d');
            
            foreach ($request->product_ids as $index => $productId) {
                $quantity = $request->quantities[$index];
                $product = Product::findOrFail($productId);
                
                // Kiểm tra lại tồn kho và giảm số lượng
                if ($product->quantity < $quantity) {
                    throw new \Exception('Sản phẩm "' . $product->name . '" không đủ số lượng. Tồn kho: ' . $product->quantity);
                }
                
                // Tính tiền cho sản phẩm này
                $itemPrice = $product->sale_price ?? $product->price;
                $itemTotal = $quantity * $itemPrice;
                
                // Giảm số lượng sản phẩm
                $product->quantity -= $quantity;
                $product->sold_count = ($product->sold_count ?? 0) + $quantity;
                $product->save();
                
                Order::create([
                    'product_id' => $productId,
                    'customer_id' => $customer->id,
                    'order_code' => $orderCode,
                    'quantity' => $quantity,
                    'total_revenue' => $itemTotal,
                    'status' => 0,
                    'order_date' => $orderDate,
                ]);
                
                Transaction::create([
                    'customer_id' => $customer->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'transaction_code' => $orderCode,
                    'transaction_date' => $orderDate,
                ]);
            }
            
            // Xóa giỏ hàng của user hiện tại
            Cart::where('user_id', auth()->id())->delete();
            
            DB::commit();
            
            // Nếu thanh toán ATM, redirect đến trang hiển thị QR code
            if ($request->payments == '1') {
                return redirect()->route('frontend.payment.qr', ['order_code' => $orderCode])
                    ->with('success', 'Đặt hàng thành công! Vui lòng quét mã QR để thanh toán.');
            }
            
            return redirect()->route('frontend.home')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }
}

