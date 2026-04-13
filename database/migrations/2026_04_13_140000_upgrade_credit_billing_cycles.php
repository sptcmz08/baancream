<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('credit_cycles')) {
            Schema::table('credit_cycles', function (Blueprint $table) {
                if (! Schema::hasColumn('credit_cycles', 'due_date')) {
                    $table->date('due_date')->nullable()->after('year');
                }

                if (! Schema::hasColumn('credit_cycles', 'payment_slip')) {
                    $table->string('payment_slip')->nullable()->after('status');
                }

                if (! Schema::hasColumn('credit_cycles', 'payment_note')) {
                    $table->text('payment_note')->nullable()->after('payment_slip');
                }

                if (! Schema::hasColumn('credit_cycles', 'payment_submitted_at')) {
                    $table->timestamp('payment_submitted_at')->nullable()->after('payment_note');
                }

                if (! Schema::hasColumn('credit_cycles', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable()->after('payment_submitted_at');
                }
            });
        }

        if (Schema::hasTable('orders') && Schema::hasTable('credit_cycles')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'credit_cycle_id')) {
                    $table->foreignId('credit_cycle_id')
                        ->nullable()
                        ->after('user_id')
                        ->constrained('credit_cycles')
                        ->nullOnDelete();
                }
            });

            DB::table('orders')
                ->whereNull('credit_cycle_id')
                ->where(function ($query) {
                    $query->where('payment_method', 'credit')
                        ->orWhere('type', 'credit');
                })
                ->chunkById(100, function ($orders) {
                    foreach ($orders as $order) {
                        $cycle = DB::table('credit_cycles')
                            ->where('user_id', $order->user_id)
                            ->where('month', (int) date('n', strtotime($order->created_at)))
                            ->where('year', (int) date('Y', strtotime($order->created_at)))
                            ->first();

                        if ($cycle) {
                            DB::table('orders')
                                ->where('id', $order->id)
                                ->update(['credit_cycle_id' => $cycle->id]);
                        }
                    }
                });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'credit_cycle_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropConstrainedForeignId('credit_cycle_id');
            });
        }

        if (Schema::hasTable('credit_cycles')) {
            Schema::table('credit_cycles', function (Blueprint $table) {
                foreach (['paid_at', 'payment_submitted_at', 'payment_note', 'payment_slip', 'due_date'] as $column) {
                    if (Schema::hasColumn('credit_cycles', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
