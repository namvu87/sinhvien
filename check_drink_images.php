<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "=== KIỂM TRA HÌNH ẢNH ĐỒ UỐNG ===\n\n";

$products = Product::where('category_id', 3)->get(['id', 'name', 'featured_image']);

foreach ($products as $product) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "ID: " . $product->id . "\n";
    echo "Tên: " . $product->name . "\n";
    echo "Hình ảnh: " . ($product->featured_image ?? 'CHƯA CÓ') . "\n";
    
    if ($product->featured_image) {
        $imagePath = public_path('images/' . $product->featured_image);
        $exists = file_exists($imagePath) ? '✓ TỒN TẠI' : '✗ KHÔNG TỒN TẠI';
        echo "File: " . $exists . "\n";
        if (file_exists($imagePath)) {
            echo "Đường dẫn đầy đủ: " . $imagePath . "\n";
        }
    }
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
}

echo "Tổng số sản phẩm đồ uống: " . $products->count() . "\n";
