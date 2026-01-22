<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category(Request $request)
    {
        $categoryId = $request->get('id');
        $category = $categoryId ? Category::find($categoryId) : null;
        
        $query = Product::where('status', 'active');
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->orderBy('id', 'desc')->paginate(12);
        
        return view('frontend.category', compact('category', 'products'));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('frontend.product-detail', compact('product'));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->get('q');
        
        $products = Product::where('status', 'active')
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orderBy('id', 'desc')
            ->paginate(12);
            
        return view('frontend.search', compact('products', 'keyword'));
    }
    
    public function newProducts()
    {
        $products = Product::where('status', 'active')
            ->where('is_new', true)
            ->orderBy('id', 'desc')
            ->paginate(12);
        
        $category = null;
        $title = 'Sản phẩm mới';
            
        return view('frontend.category', compact('products', 'category', 'title'));
    }
    
    public function bestSellers()
    {
        $products = Product::where('status', 'active')
            ->where('is_bestseller', true)
            ->orderBy('sold_count', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(12);
        
        $category = null;
        $title = 'Sản phẩm bán chạy';
            
        return view('frontend.category', compact('products', 'category', 'title'));
    }
    
    public function discountedProducts()
    {
        $products = Product::where('status', 'active')
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->orderByRaw('((price - sale_price) / price * 100) DESC')
            ->orderBy('id', 'desc')
            ->paginate(12);
        
        $category = null;
        $title = 'Sản phẩm giảm giá';
            
        return view('frontend.category', compact('products', 'category', 'title'));
    }
}

