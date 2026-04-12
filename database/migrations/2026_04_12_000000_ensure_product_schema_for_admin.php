<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'sku')) {
                    $table->string('sku')->nullable()->unique()->after('id');
                }

                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }

                if (!Schema::hasColumn('products', 'retail_price')) {
                    $table->decimal('retail_price', 10, 2)->default(0)->after('description');
                }

                if (!Schema::hasColumn('products', 'wholesale_price')) {
                    $table->decimal('wholesale_price', 10, 2)->default(0)->after('retail_price');
                }

                if (!Schema::hasColumn('products', 'image')) {
                    $table->string('image')->nullable()->after('wholesale_price');
                }

                if (!Schema::hasColumn('products', 'stock')) {
                    $table->integer('stock')->default(0)->after('image');
                }

                if (!Schema::hasColumn('products', 'wholesale_min_qty')) {
                    $table->integer('wholesale_min_qty')->default(10)->after('stock');
                }

                if (!Schema::hasColumn('products', 'images')) {
                    $table->json('images')->nullable()->after('image');
                }

                if (!Schema::hasColumn('products', 'is_new_arrival')) {
                    $table->boolean('is_new_arrival')->default(false)->after('images');
                }

                if (!Schema::hasColumn('products', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }

        if (Schema::hasTable('product_variants')) {
            Schema::table('product_variants', function (Blueprint $table) {
                if (!Schema::hasColumn('product_variants', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }

                if (!Schema::hasColumn('product_variants', 'images')) {
                    $table->json('images')->nullable()->after('image');
                }

                if (!Schema::hasColumn('product_variants', 'wholesale_min_qty')) {
                    $table->unsignedInteger('wholesale_min_qty')->default(10)->after('wholesale_price');
                }
            });
        }

        if (!Schema::hasTable('category_product') && Schema::hasTable('categories') && Schema::hasTable('products')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
