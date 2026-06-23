<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_salles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salle_id');
            $table->unsignedBigInteger('teacher_id');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('motif')->nullable();
            $table->string('statut')->default('en_attente');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_salles');
    }
};
