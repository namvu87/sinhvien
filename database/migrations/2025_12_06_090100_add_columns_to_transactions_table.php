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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'customer_id')) {
                $table->foreignId('customer_id')->after('id')->constrained('customers')->onDelete('cascade');
            }
            if (!Schema::hasColumn('transactions', 'product_id')) {
                $table->foreignId('product_id')->after('customer_id')->constrained('products')->onDelete('cascade');
            }
            if (!Schema::hasColumn('transactions', 'quantity')) {
                $table->integer('quantity')->after('product_id');
            }
            if (!Schema::hasColumn('transactions', 'transaction_code')) {
                $table->string('transaction_code', 50)->after('quantity')->comment('Mã giao dịch');
            }
            if (!Schema::hasColumn('transactions', 'transaction_date')) {
                $table->date('transaction_date')->after('transaction_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['customer_id', 'product_id', 'quantity', 'transaction_code', 'transaction_date']);
        });
    }
};

