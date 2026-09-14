<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('department', 'specialite');
            $table->string('city')->nullable()->after('phone');
        });

        Schema::table('interns', function (Blueprint $table) {
            $table->renameColumn('department', 'specialite');
            $table->string('city')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('specialite', 'department');
            $table->dropColumn('city');
        });

        Schema::table('interns', function (Blueprint $table) {
            $table->renameColumn('specialite', 'department');
            $table->dropColumn('city');
        });
    }
};
