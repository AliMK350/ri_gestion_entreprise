<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('justificatif_absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('absence_id')->nullable();
            $table->string('file_path');
            $table->text('commentaire')->nullable();
            $table->string('statut')->default('en_attente');
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('absence_id')->references('id')->on('absences')->nullOnDelete();
            $table->foreign('validated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('justificatif_absences');
    }
};

