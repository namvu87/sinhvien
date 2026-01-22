<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('order_code', 50)->unique()->comment('Mã đơn hàng');
            $table->integer('quantity');
            $table->decimal('total_revenue', 10, 2)->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Chưa xác nhận, 1: Đã xác nhận, 2: Đã hủy');
            $table->date('order_date');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
