<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvtech_people', function (Blueprint $table) {
            $table->id();
            $table->string('person_type');
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('specialite')->nullable();
            $table->string('position')->nullable();
            $table->string('niveau_etude')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->date('hired_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['source_type', 'source_id']);
            $table->index(['person_type', 'name']);
        });

        foreach (DB::table('employees')->get() as $employee) {
            DB::table('cvtech_people')->insert([
                'person_type' => 'employee',
                'source_type' => 'employee',
                'source_id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'city' => $employee->city,
                'specialite' => $employee->specialite,
                'position' => $employee->position,
                'hired_at' => $employee->hired_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (DB::table('interns')->get() as $intern) {
            DB::table('cvtech_people')->insert([
                'person_type' => 'intern',
                'source_type' => 'intern',
                'source_id' => $intern->id,
                'name' => $intern->name,
                'email' => $intern->email,
                'phone' => $intern->phone,
                'city' => $intern->city,
                'specialite' => $intern->specialite,
                'niveau_etude' => $intern->niveau_etude,
                'started_at' => $intern->started_at,
                'ended_at' => $intern->ended_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cvtech_people');
    }
};
