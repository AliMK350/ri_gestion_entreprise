<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('subject_name')->nullable();
            $table->string('jour')->nullable();
            $table->string('heure')->nullable();
            $table->string('salle')->nullable();
            $table->date('date_seance')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('class_id')->references('id')->on('class')->nullOnDelete();
            $table->foreign('teacher_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emplois_du_temps');
    }
};

