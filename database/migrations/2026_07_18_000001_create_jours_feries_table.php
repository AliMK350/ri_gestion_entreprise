<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Crée la table jours_feries.
     * - type 'fixe'     : jours fériés marocains à date fixe chaque année
     * - type 'religieux': jours fériés dont la date varie (Aïd, Mawlid…)
     *                     et sont gérés manuellement par l'administrateur.
     */
    public function up(): void
    {
        Schema::create('jours_feries', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                        // Libellé du jour férié
            $table->date('date');                         // Date exacte
            $table->enum('type', ['fixe', 'religieux'])  // Catégorie
                  ->default('fixe');
            $table->timestamps();

            // Unicité sur la date : pas deux jours fériés le même jour
            $table->unique('date');
        });
    }

    /**
     * Supprime la table jours_feries.
     */
    public function down(): void
    {
        Schema::dropIfExists('jours_feries');
    }
};
