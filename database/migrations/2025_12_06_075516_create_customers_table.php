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
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 100);
            $table->string('user_code', 10)->nullable();
            $table->string('customer_phone', 50);
            $table->string('customer_email', 150);
            $table->text('customer_address');
            $table->tinyInteger('payments')->default(0)->comment('0: Chưa thanh toán, 1: Đã thanh toán');
            $table->text('customer_note')->nullable();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
