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
        if (Schema::hasTable('products')) {
            if (Schema::hasColumn('products', 'brand_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropConstrainedForeignId('brand_id');
                });
            }

            if (Schema::hasColumn('products', 'category_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropConstrainedForeignId('category_id');
                });
            }

            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'stock')) {
                    $table->integer('stock')->default(0)->after('wholesale_price');
                }
                if (! Schema::hasColumn('products', 'wholesale_min_qty')) {
                    $table->integer('wholesale_min_qty')->default(10)->after('stock');
                }
                if (! Schema::hasColumn('products', 'images')) {
                    $table->json('images')->nullable()->after('image');
                }
            });
        }

        Schema::dropIfExists('brands');

        if (! Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('product_variants')) {
            Schema::table('product_variants', function (Blueprint $table) {
                if (Schema::hasColumn('product_variants', 'sku')) {
                    $table->dropColumn('sku');
                }
                if (! Schema::hasColumn('product_variants', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
            });
        }
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
