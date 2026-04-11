<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('order_note');
            $table->string('pickup_image')->nullable()->after('tracking_number');
            $table->timestamp('pickup_at')->nullable()->after('pickup_image');
            $table->string('cod_image')->nullable()->after('pickup_at');
            $table->timestamp('cod_uploaded_at')->nullable()->after('cod_image');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('cod_uploaded_at');
            $table->text('customer_notes')->nullable()->after('shipping_cost');
            $table->boolean('user_read_status')->default(false)->after('customer_notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'tracking_number',
                'pickup_image',
                'pickup_at',
                'cod_image',
                'cod_uploaded_at',
                'shipping_cost',
                'customer_notes',
                'user_read_status',
            ]);
        });
    }
};
