<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Chỉ hiển thị giỏ hàng khi đã đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        }
        
        $cartItems = Cart::where('user_id', auth()->id())->get();
        return view('frontend.cart', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        // Chỉ cho phép thêm vào giỏ hàng khi đã đăng nhập
        if (!auth()->check()) {
            // Lưu URL hiện tại để quay lại sau khi đăng nhập
            $previousUrl = url()->previous();
            
            return redirect($previousUrl)
                ->with('error', '⚠️ Vui lòng đăng nhập để mua hàng!')
                ->with('login_required', true)
                ->with('message_type', 'login_required');
        }
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Kiểm tra số lượng tồn kho
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Số lượng sản phẩm không đủ. Tồn kho hiện tại: ' . $product->quantity);
        }
        
        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();
        
        if ($existingCart) {
            $newQuantity = $existingCart->product_quantity + $request->quantity;
            // Kiểm tra lại tồn kho
            if ($product->quantity < $newQuantity) {
                return back()->with('error', 'Số lượng sản phẩm không đủ. Tồn kho hiện tại: ' . $product->quantity);
            }
            $existingCart->product_quantity = $newQuantity;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_name' => $product->name,
                'product_id' => $product->id,
                'product_price' => $product->sale_price ?? $product->price,
                'product_image' => $product->featured_image,
                'product_quantity' => $request->quantity,
            ]);
        }
        
        return redirect()->route('frontend.cart')->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }
    
    public function update(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }
        
        $quantities = $request->input('quantities', []);
        
        foreach ($quantities as $cartId => $quantity) {
            $cart = Cart::where('id', $cartId)
                ->where('user_id', auth()->id())
                ->first();
            
            if ($cart) {
                if ($quantity <= 0) {
                    $cart->delete();
                } else {
                    // Kiểm tra tồn kho
                    $product = Product::find($cart->product_id);
                    if ($product && $product->quantity < $quantity) {
                        return back()->with('error', 'Số lượng sản phẩm "' . $product->name . '" không đủ. Tồn kho hiện tại: ' . $product->quantity);
                    }
                    $cart->product_quantity = $quantity;
                    $cart->save();
                }
            }
        }
        
        return redirect()->route('frontend.cart')->with('success', 'Đã cập nhật giỏ hàng');
    }
    
    public function remove($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }
        
        Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();
            
        return redirect()->route('frontend.cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }
}

