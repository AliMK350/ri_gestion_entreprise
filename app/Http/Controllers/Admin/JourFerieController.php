<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JourFerie;
use Illuminate\Http\Request;

/**
 * Gestion CRUD des jours fériés (réservé à l'administrateur).
 *
 * Routes attendues (préfixe : admin/jours-feries) :
 *   GET  /list          → list()
 *   GET  /add           → add()
 *   POST /add           → insert()
 *   GET  /edit/{id}     → edit()
 *   POST /edit/{id}     → update()
 *   GET  /delete/{id}   → delete()
 */
class JourFerieController extends Controller
{
    // ─── Règles de validation communes ──────────────────────────────────────

    /**
     * Retourne les règles de validation pour le formulaire.
     *
     * @param int|null $ignoreId  ID à ignorer pour la règle d'unicité (lors d'un update)
     */
    private function validationRules(?int $ignoreId = null): array
    {
        $uniqueRule = 'unique:jours_feries,date';
        if ($ignoreId) {
            $uniqueRule .= ',' . $ignoreId;
        }

        return [
            'nom'  => 'required|string|max:255',
            'date' => ['required', 'date', $uniqueRule],
            'type' => 'required|in:fixe,religieux',
            'duree' => 'nullable|numeric|min:1',
        ];
    }

    private function validationMessages(): array
    {
        return [
            'nom.required'  => 'Le nom du jour férié est obligatoire.',
            'date.required' => 'La date est obligatoire.',
            'date.date'     => 'La date saisie n\'est pas valide.',
            'date.unique'   => 'Un jour férié est déjà enregistré à cette date.',
            'type.required' => 'Le type est obligatoire.',
            'type.in'       => 'Le type doit être "fixe" ou "religieux".',
            'duree.numeric' => 'La durée doit être un nombre.',
            'duree.min'     => 'La durée doit être au moins de 1 jour.',
        ];
    }

    // ─── Actions CRUD ────────────────────────────────────────────────────────

    /**
     * Liste tous les jours fériés avec filtres optionnels (type, année).
     */
    public function list()
    {
        $data['getRecord']    = JourFerie::getHolidays();
        $data['header_title'] = 'Jours Fériés';
        // Années disponibles pour le filtre (basées sur les enregistrements existants)
        $data['years'] = JourFerie::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.jours-feries.list', $data);
    }

    /**
     * Affiche le formulaire d'ajout.
     */
    public function add()
    {
        $data['header_title'] = 'Ajouter un Jour Férié';
        return view('admin.jours-feries.add', $data);
    }

    /**
     * Enregistre un nouveau jour férié.
     */
    public function insert(Request $request)
    {
        $request->validate($this->validationRules(), $this->validationMessages());

        JourFerie::create([
            'nom'   => trim($request->nom),
            'date'  => $request->date,
            'type'  => $request->type,
            'duree' => $request->duree ?: 1,
        ]);

        return redirect('admin/jours-feries/list')
            ->with('success', 'Jour férié ajouté avec succès.');
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(int $id)
    {
        $data['getRecord'] = JourFerie::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Modifier le Jour Férié';
        return view('admin.jours-feries.edit', $data);
    }

    /**
     * Met à jour un jour férié existant.
     */
    public function update(int $id, Request $request)
    {
        $jourFerie = JourFerie::getSingle($id);
        if (empty($jourFerie)) {
            abort(404);
        }

        $request->validate($this->validationRules($id), $this->validationMessages());

        $jourFerie->nom   = trim($request->nom);
        $jourFerie->date  = $request->date;
        $jourFerie->type  = $request->type;
        $jourFerie->duree = $request->duree ?: 1;
        $jourFerie->save();

        return redirect('admin/jours-feries/list')
            ->with('success', 'Jour férié mis à jour avec succès.');
    }

    /**
     * Supprime un jour férié.
     */
    public function delete(int $id)
    {
        $jourFerie = JourFerie::getSingle($id);
        if (empty($jourFerie)) {
            abort(404);
        }
        $jourFerie->delete();

        return redirect('admin/jours-feries/list')
            ->with('success', 'Jour férié supprimé avec succès.');
    }

    /**
     * Importer des jours fériés depuis un fichier CSV ou XLSX.
     * Attendu : colonnes nom,date,type,duree (duree optionnelle)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());

        $rows = [];

        try {
            if (in_array($ext, ['xls', 'xlsx']) && class_exists('\\PhpOffice\\PhpSpreadsheet\\IOFactory')) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
                $sheet = $reader->getActiveSheet();
                foreach ($sheet->getRowIterator() as $row) {
                    $cells = [];
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                    foreach ($cellIterator as $cell) {
                        $cells[] = $cell->getValue();
                    }
                    $rows[] = $cells;
                }
            } else {
                // Traite comme CSV
                $handle = fopen($file->getPathname(), 'r');
                while (($data = fgetcsv($handle, 0, ',')) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }
        } catch (\Exception $e) {
            return redirect('admin/jours-feries/list')->with('error', 'Erreur lors de la lecture du fichier : ' . $e->getMessage());
        }

        // Tentative d'interprétation : première ligne header possible
        $created = 0;
        foreach ($rows as $i => $r) {
            if ($i === 0) {
                $header = array_map(fn($h) => strtolower(trim((string) $h)), $r);
                if (in_array('nom', $header) && in_array('date', $header)) {
                    continue; // header détecté
                }
            }

            // Supporte deux formats : [nom,date,type,duree] ou associative header
            if (!empty($header) && count($header) === count($r)) {
                $rowAssoc = array_combine($header, $r);
                $nom = trim($rowAssoc['nom'] ?? ($rowAssoc['name'] ?? ''));
                $date = $rowAssoc['date'] ?? null;
                $type = $rowAssoc['type'] ?? 'fixe';
                $duree = $rowAssoc['duree'] ?? 1;
            } else {
                $nom = trim($r[0] ?? '');
                $date = $r[1] ?? null;
                $type = $r[2] ?? 'fixe';
                $duree = $r[3] ?? 1;
            }

            if (empty($nom) || empty($date)) {
                continue;
            }

            try {
                $dateObj = \Carbon\Carbon::parse($date);
            } catch (\Exception $e) {
                continue; // ignore invalid date
            }

            $created += (int) JourFerie::firstOrCreate([
                'date' => $dateObj->toDateString(),
            ], [
                'nom'   => $nom,
                'type'  => in_array($type, ['fixe','religieux']) ? $type : 'fixe',
                'duree' => is_numeric($duree) ? (float)$duree : 1,
            ]) ? 1 : 0;
        }

        return redirect('admin/jours-feries/list')
            ->with('success', "Import terminé. {$created} lignes ajoutées.");
    }

    /**
     * Supprime toutes les dates non fixes (type != 'fixe').
     */
    public function deleteNonFixed(Request $request)
    {
        $count = JourFerie::where('type', '<>', 'fixe')->count();
        JourFerie::where('type', '<>', 'fixe')->delete();

        return redirect('admin/jours-feries/list')
            ->with('success', "Suppression terminée. {$count} enregistrements supprimés.");
    }
}
