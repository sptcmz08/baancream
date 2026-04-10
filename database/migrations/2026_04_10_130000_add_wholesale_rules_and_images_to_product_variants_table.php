<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (! Schema::hasColumn('product_variants', 'wholesale_min_qty')) {
                $table->unsignedInteger('wholesale_min_qty')->default(10)->after('wholesale_price');
            }

            if (! Schema::hasColumn('product_variants', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (Schema::hasColumn('product_variants', 'images')) {
                $table->dropColumn('images');
            }

            if (Schema::hasColumn('product_variants', 'wholesale_min_qty')) {
                $table->dropColumn('wholesale_min_qty');
            }
        });
    }
};
