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
        // 1. Remove brand_id and category_id from products
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['brand_id', 'category_id']);
            
            $table->integer('stock')->default(0)->after('wholesale_price');
            $table->integer('wholesale_min_qty')->default(10)->after('stock');
            $table->json('images')->nullable()->after('image');
        });

        // 2. Drop brands table
        Schema::dropIfExists('brands');

        // 3. Create category_product table
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        });

        // 4. Update product_variants table
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('sku');
            $table->text('description')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        // Reverse operations
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::dropIfExists('category_product');

        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('sku')->nullable();
            $table->dropColumn('description');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->dropColumn(['stock', 'wholesale_min_qty', 'images']);
        });
    }
};
