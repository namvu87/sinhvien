<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "=== KIỂM TRA VÀ SỬA ĐƯỜNG DẪN HÌNH ẢNH ===\n\n";

$products = Product::where('category_id', 3)->get();

foreach ($products as $product) {
    if (!$product->featured_image) {
        continue;
    }
    
    echo "Sản phẩm: {$product->name}\n";
    echo "  Database: {$product->featured_image}\n";
    
    // Kiểm tra các vị trí có thể
    $paths = [
        public_path('images/' . $product->featured_image),
        public_path('storage/' . $product->featured_image),
        storage_path('app/public/' . $product->featured_image),
    ];
    
    $found = false;
    foreach ($paths as $path) {
        if (file_exists($path)) {
            echo "  ✓ Tìm thấy tại: " . str_replace(public_path(), 'public', $path) . "\n";
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo "  ✗ Không tìm thấy file\n";
    }
    
    echo "\n";
}

echo "=== GHI CHÚ ===\n";
echo "Nếu file được lưu trong storage/app/public/products/, cần dùng Storage::url()\n";
echo "Nếu file được lưu trong public/images/products/, dùng asset('images/...')\n";
