<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeAdministrativeController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Demandes administratives';
        $data['demandes'] = DemandeAdministrative::where('teacher_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.demandes.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Nouvelle demande administrative';

        return view('secretaire.demandes.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        DemandeAdministrative::create([
            'teacher_id' => Auth::id(),
            'objet' => $request->objet,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('teacher.demandes.index')->with('success', 'Demande envoyee avec succes.');
    }
}
