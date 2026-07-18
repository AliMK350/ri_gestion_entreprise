<?php

namespace Database\Seeders;

use App\Models\JourFerie;
use Illuminate\Database\Seeder;

/**
 * Génère les jours fériés FIXES marocains pour l'année courante.
 *
 * Les jours fériés religieux (Aïd al-Fitr, Aïd al-Adha, 1er Mouharram,
 * Aïd al-Mawlid, etc.) ne sont PAS inclus ici car leurs dates changent
 * chaque année selon les annonces officielles ; ils doivent être ajoutés
 * manuellement par l'administrateur via l'interface CRUD.
 *
 * Ce seeder utilise firstOrCreate() pour être idempotent : il peut être
 * relancé sans risque de doublons.
 */
class JoursFeriesSeeder extends Seeder
{
    /**
     * Jours fériés fixes marocains (mois-jour uniquement).
     * Le mois et le jour sont constants chaque année.
     */
    private const FIXED_HOLIDAYS = [
        ['month' => 1,  'day' => 1,  'nom' => 'Nouvel An'],
        ['month' => 1,  'day' => 11, 'nom' => "Manifeste de l'Indépendance"],
        ['month' => 5,  'day' => 1,  'nom' => 'Fête du Travail'],
        ['month' => 7,  'day' => 30, 'nom' => 'Fête du Trône'],
        ['month' => 8,  'day' => 14, 'nom' => "Allégeance de l'Oued-Ed-Dahab"],
        ['month' => 8,  'day' => 20, 'nom' => 'Révolution du Roi et du Peuple'],
        ['month' => 8,  'day' => 21, 'nom' => 'Fête de la Jeunesse'],
        ['month' => 11, 'day' => 6,  'nom' => 'Marche Verte'],
        ['month' => 11, 'day' => 18, 'nom' => "Fête de l'Indépendance"],
    ];

    public function run(): void
    {
        $year = now()->year;

        foreach (self::FIXED_HOLIDAYS as $holiday) {
            $date = sprintf('%d-%02d-%02d', $year, $holiday['month'], $holiday['day']);

            JourFerie::firstOrCreate(
                ['date' => $date],                // Clé de recherche (unicité)
                ['nom'  => $holiday['nom'], 'type' => 'fixe']
            );
        }

        $this->command->info("✅ {$year} : " . count(self::FIXED_HOLIDAYS) . ' jours fériés fixes générés (ou déjà existants).');
    }
}
