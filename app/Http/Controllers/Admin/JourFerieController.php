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
            'nom'  => trim($request->nom),
            'date' => $request->date,
            'type' => $request->type,
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

        $jourFerie->nom  = trim($request->nom);
        $jourFerie->date = $request->date;
        $jourFerie->type = $request->type;
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
}
