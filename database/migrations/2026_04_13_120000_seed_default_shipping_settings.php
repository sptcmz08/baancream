<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $now = now();
        $defaults = [
            'shipping_base_fee' => '30',
            'shipping_rules' => json_encode([
                ['min_qty' => 1, 'max_qty' => 5, 'fee' => 30],
                ['min_qty' => 6, 'max_qty' => 10, 'fee' => 50],
                ['min_qty' => 11, 'max_qty' => 20, 'fee' => 70],
                ['min_qty' => 21, 'max_qty' => null, 'fee' => 90],
            ], JSON_UNESCAPED_UNICODE),
        ];

        foreach ($defaults as $key => $value) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        DB::table('site_settings')
            ->whereIn('key', ['shipping_base_fee', 'shipping_rules'])
            ->delete();
    }
};
