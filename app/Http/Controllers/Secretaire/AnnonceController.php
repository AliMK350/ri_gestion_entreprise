<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Annonces';
        $data['annonces'] = Annonce::where('created_by', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.annonces.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Publier une annonce';

        return view('secretaire.annonces.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        Annonce::create([
            'title' => $request->title,
            'contenu' => $request->contenu,
            'created_by' => Auth::id(),
            'status' => 0,
        ]);

        return redirect()->route('teacher.annonces.index')->with('success', 'Annonce publiee avec succes.');
    }
}
