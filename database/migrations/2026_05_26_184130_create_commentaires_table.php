<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('annonce_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->text('contenu');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('annonce_id')->references('id')->on('annonces')->nullOnDelete();
            $table->foreign('student_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};

