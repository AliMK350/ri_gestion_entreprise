<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('leave_balance_days', 5, 2)->default(0.00)->change();
            $table->date('last_leave_reset_at')->nullable()->after('leave_balance_days');
        });

        // Set default initial balance to 0.00 for new employees without custom balances
        DB::table('employees')->where('leave_balance_days', 18.00)->update(['leave_balance_days' => 0.00]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('leave_balance_days', 5, 2)->default(18.00)->change();
            $table->dropColumn('last_leave_reset_at');
        });
    }
};
