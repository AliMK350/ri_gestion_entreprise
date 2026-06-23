<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Classroom';
        $data['user'] = Auth::user();
        $data['annonces'] = Annonce::where('status', 0)
            ->orderBy('id', 'desc')
            ->get();
        $data['commentaires'] = Commentaire::where('status', 0)
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        return view('employe.classroom.index', $data);
    }

    /**
     * Store a new comment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
            'annonce_id' => 'nullable|exists:annonces,id',
        ]);

        Commentaire::create([
            'annonce_id' => $request->input('annonce_id'),
            'student_id' => Auth::id(),
            'contenu' => $request->input('contenu'),
            'status' => 0,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }
}
