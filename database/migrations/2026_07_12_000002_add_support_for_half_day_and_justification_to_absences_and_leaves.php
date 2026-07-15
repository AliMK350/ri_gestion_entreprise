<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->string('half_day')->nullable()->after('date');
            $table->string('justification_file')->nullable()->after('reason');
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->string('justification_file')->nullable()->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn(['half_day', 'justification_file']);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('justification_file');
        });
    }
};
