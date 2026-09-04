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
            $table->decimal('leave_balance_days', 5, 2)->default(18.00)->change();
        });

        // Set default 18 for employees currently having 20 or null if any
        DB::table('employees')->where('leave_balance_days', 20)->update(['leave_balance_days' => 18.00]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('leave_balance_days')->default(20)->change();
        });
    }
};
