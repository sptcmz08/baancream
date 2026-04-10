<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('type');
            $table->string('recipient_name')->nullable()->after('slip_image');
            $table->string('phone')->nullable()->after('recipient_name');
            $table->text('address_line')->nullable()->after('phone');
            $table->string('subdistrict')->nullable()->after('address_line');
            $table->string('district')->nullable()->after('subdistrict');
            $table->string('province')->nullable()->after('district');
            $table->string('postal_code', 20)->nullable()->after('province');
            $table->text('order_note')->nullable()->after('postal_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'recipient_name',
                'phone',
                'address_line',
                'subdistrict',
                'district',
                'province',
                'postal_code',
                'order_note',
            ]);
        });
    }
};
