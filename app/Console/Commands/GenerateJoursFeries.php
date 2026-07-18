<?php

namespace App\Console\Commands;

use App\Models\JourFerie;
use Illuminate\Console\Command;

/**
 * Commande Artisan pour générer les jours fériés fixes marocains d'une année.
 *
 * Usage :
 *   php artisan feries:generate          → année en cours
 *   php artisan feries:generate 2027     → année 2027
 *
 * Cette commande est idempotente : relancée plusieurs fois, elle ne crée
 * pas de doublons grâce à firstOrCreate() sur la colonne 'date'.
 */
class GenerateJoursFeries extends Command
{
    /** @var string Signature de la commande avec un paramètre optionnel {year?} */
    protected $signature = 'feries:generate {year? : L\'année cible (par défaut : année courante)}';

    protected $description = 'Génère les jours fériés fixes marocains pour une année donnée';

    /**
     * Jours fériés fixes marocains (mois-jour constants).
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

    public function handle(): int
    {
        // Récupère l'année passée en argument, ou l'année courante par défaut
        $year = (int) ($this->argument('year') ?? now()->year);

        if ($year < 2000 || $year > 2100) {
            $this->error("Année invalide : {$year}. Veuillez fournir une année entre 2000 et 2100.");
            return self::FAILURE;
        }

        $this->info("Génération des jours fériés fixes pour l'année {$year}…");

        $created = 0;
        $skipped = 0;

        foreach (self::FIXED_HOLIDAYS as $holiday) {
            $date = sprintf('%d-%02d-%02d', $year, $holiday['month'], $holiday['day']);

            [$record, $wasCreated] = [
                JourFerie::firstOrCreate(
                    ['date' => $date],
                    ['nom' => $holiday['nom'], 'type' => 'fixe']
                ),
                false,
            ];

            // firstOrCreate ne retourne pas un booléen directement
            $wasCreated = $record->wasRecentlyCreated;
            $wasCreated ? $created++ : $skipped++;

            $this->line(
                ($wasCreated ? '  <fg=green>✓</>' : '  <fg=yellow>~</>') .
                "  {$date}  {$holiday['nom']}" .
                ($wasCreated ? '' : ' (déjà existant)')
            );
        }

        $this->newLine();
        $this->info("✅ Terminé — {$created} créé(s), {$skipped} ignoré(s) (déjà existants).");

        return self::SUCCESS;
    }
}
