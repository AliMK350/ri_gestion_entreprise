<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeAdministrativeController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Mes demandes administratives';
        $data['user'] = Auth::user();
        $query = DemandeAdministrative::where('student_id', Auth::id());
        if ($status = request('status')) {
            $query->where('statut', $status);
        }
        $data['demandes'] = $query->orderBy('id', 'desc')->get();

        return view('employe.demandes.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Nouvelle demande administrative';
        $data['user'] = Auth::user();

        return view('employe.demandes.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        DemandeAdministrative::create([
            'student_id' => Auth::id(),
            'objet' => $request->objet,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('student.demandes.index')
            ->with('success', 'Demande envoyee avec succes.');
    }

    /**
     * Show a single demande.
     */
    public function show($id)
    {
        $demande = DemandeAdministrative::where('student_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        $data['header_title'] = 'Détail de la demande';
        $data['user'] = Auth::user();
        $data['demande'] = $demande;
        return view('employe.demandes.show', $data);
    }
}
