<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\CahierTexte;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CahierTexteController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Cahier de texte';
        $data['entries'] = CahierTexte::where('teacher_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.cahier-texte.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Nouvelle entree cahier de texte';
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.cahier-texte.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_seance' => 'nullable|date',
        ]);

        CahierTexte::create([
            'teacher_id' => Auth::id(),
            'subject_name' => $request->subject_name,
            'contenu' => $request->contenu,
            'date_seance' => $request->date_seance,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.cahier-texte.index')->with('success', 'Entree ajoutee avec succes.');
    }

    public function edit($id)
    {
        $data['getRecord'] = CahierTexte::where('teacher_id', Auth::id())->findOrFail($id);
        $data['header_title'] = 'Modifier cahier de texte';
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.cahier-texte.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'contenu' => 'required|string',
            'date_seance' => 'nullable|date',
        ]);

        $entry = CahierTexte::where('teacher_id', Auth::id())->findOrFail($id);
        $entry->update([
            'subject_name' => $request->subject_name,
            'contenu' => $request->contenu,
            'date_seance' => $request->date_seance,
        ]);

        return redirect()->route('teacher.cahier-texte.index')->with('success', 'Entree mise a jour avec succes.');
    }
}
