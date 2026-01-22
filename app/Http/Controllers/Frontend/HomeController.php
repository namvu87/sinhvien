<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->with(['products' => function($query) {
                $query->where('status', 'active')->orderBy('id', 'desc')->limit(6);
            }])
            ->orderBy('display_order')
            ->get();
            
        return view('frontend.home', compact('categories'));
    }
}

