<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        $orders = Order::whereHas('customer', function($query) use ($user) {
            $query->where('customer_email', $user->email);
        })->with('product')->orderBy('created_at', 'desc')->get();
        
        return view('frontend.orders', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['product', 'customer'])->findOrFail($id);
        return view('frontend.order-detail', compact('order'));
    }
}

