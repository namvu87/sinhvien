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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku', 100)->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('short_description', 500)->nullable();

            // Pricing
            $table->decimal('price', 15, 2);
            $table->decimal('sale_price', 15, 2)->nullable();

            // Inventory
            $table->integer('quantity')->default(0);

            // Media
            $table->string('featured_image')->nullable();

            // Specifications
            $table->json('specifications')->nullable();

            // Status flags
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Stats
            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index('category_id', 'idx_category_id');
            $table->index('brand_id', 'idx_brand_id');
            $table->index('slug', 'idx_slug');
            $table->index('sku', 'idx_sku');
            $table->index('price', 'idx_price');
            $table->index('status', 'idx_status');
            $table->index('is_featured', 'idx_featured');

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
