<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_credit_enabled')->default(false)->after('default_credit_limit');
            $table->date('credit_due_date')->nullable()->after('is_credit_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_credit_enabled', 'credit_due_date']);
        });
    }
};
