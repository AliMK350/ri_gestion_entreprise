<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\JustificatifAbsence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JustificatifController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Mes justificatifs';
        $data['user'] = Auth::user();
        $data['justificatifs'] = JustificatifAbsence::where('student_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('employe.justificatifs.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Déposer un justificatif';
        $data['user'] = Auth::user();

        return view('employe.justificatifs.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'commentaire' => 'nullable|string',
        ]);

        $filePath = $request->file('fichier')->store('justificatifs', 'public');

        JustificatifAbsence::create([
            'student_id' => Auth::id(),
            'file_path' => $filePath,
            'commentaire' => $request->commentaire,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('student.justificatifs.index')->with('success', 'Justificatif depose avec succes.');
    }
}

