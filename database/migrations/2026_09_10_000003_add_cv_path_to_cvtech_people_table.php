<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cvtech_people', function (Blueprint $table) {
            $table->string('cv_path')->nullable()->after('notes');
        });

        DB::table('cvtech_people')
            ->join('employees', function ($join) {
                $join->on('cvtech_people.source_id', '=', 'employees.id')
                    ->where('cvtech_people.source_type', '=', 'employee');
            })
            ->whereNotNull('employees.cv_path')
            ->update(['cvtech_people.cv_path' => DB::raw('employees.cv_path')]);

        DB::table('cvtech_people')
            ->join('interns', function ($join) {
                $join->on('cvtech_people.source_id', '=', 'interns.id')
                    ->where('cvtech_people.source_type', '=', 'intern');
            })
            ->whereNotNull('interns.cv_path')
            ->update(['cvtech_people.cv_path' => DB::raw('interns.cv_path')]);
    }

    public function down(): void
    {
        Schema::table('cvtech_people', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
    }
};
