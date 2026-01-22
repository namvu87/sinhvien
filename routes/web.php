<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;

// Authentication Routes
Route::get('/login', function() {
    return redirect()->route('frontend.home')->with('login_required', true);
})->name('login');
Route::post('/login', function(\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('frontend.home'));
    }
    
    return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
})->name('login.post');

Route::post('/register', function(\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:50',
        'address' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);
    
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'address' => $validated['address'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        'role' => 0, // Customer
        'user_code' => 0,
    ]);
    
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('frontend.home')->with('success', 'Đăng ký thành công!');
})->name('register');

Route::post('/logout', function(\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('frontend.home');
})->name('logout');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/danh-muc', [ProductController::class, 'category'])->name('frontend.category');
Route::get('/san-pham/{id}', [ProductController::class, 'show'])->name('frontend.product-detail');
Route::get('/tim-kiem', [ProductController::class, 'search'])->name('frontend.search');
Route::get('/san-pham-moi', [ProductController::class, 'newProducts'])->name('frontend.products.new');
Route::get('/san-pham-ban-chay', [ProductController::class, 'bestSellers'])->name('frontend.products.bestsellers');
Route::get('/san-pham-giam-gia', [ProductController::class, 'discountedProducts'])->name('frontend.products.discounted');
Route::get('/gioi-thieu', function() { return view('frontend.about'); })->name('frontend.about');
Route::get('/lien-he', function() { return view('frontend.contact'); })->name('frontend.contact');

// Cart Routes
Route::get('/gio-hang', [CartController::class, 'index'])->name('frontend.cart');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('frontend.cart.add');
Route::post('/gio-hang/cap-nhat', [CartController::class, 'update'])->name('frontend.cart.update');
Route::get('/gio-hang/xoa/{id}', [CartController::class, 'remove'])->name('frontend.cart.remove');

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('frontend.checkout');
    Route::post('/thanh-toan/xu-ly', [CheckoutController::class, 'process'])->name('frontend.checkout.process');
    Route::get('/thanh-toan/qr/{order_code}', [PaymentController::class, 'showQR'])->name('frontend.payment.qr');
    Route::get('/don-mua', [OrderController::class, 'index'])->name('frontend.orders');
    Route::get('/don-mua/{id}', [OrderController::class, 'show'])->name('frontend.order-detail');
    Route::get('/ho-so', [ProfileController::class, 'index'])->name('frontend.profile');
    Route::put('/ho-so', [ProfileController::class, 'update'])->name('frontend.profile.update');
    Route::get('/quen-mat-khau', function() { return view('frontend.forgot-password'); })->name('frontend.forgot-password');
});
