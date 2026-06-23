<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Gestion des Annonces';
        $data['annonces'] = Annonce::orderBy('id', 'desc')->get();

        return view('admin.annonces.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Ajouter une Annonce';
        return view('admin.annonces.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contenu' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Annonce::create([
            'title' => $request->title,
            'contenu' => $request->contenu,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect('admin/annonces/list')->with('success', 'Annonce créée avec succès.');
    }

    public function edit($id)
    {
        $data['annonce'] = Annonce::findOrFail($id);
        $data['header_title'] = 'Modifier une Annonce';
        return view('admin.annonces.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'contenu' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $annonce->update([
            'title' => $request->title,
            'contenu' => $request->contenu,
            'status' => $request->status,
        ]);

        return redirect('admin/annonces/list')->with('success', 'Annonce mise à jour avec succès.');
    }

    public function delete($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->delete();

        return redirect('admin/annonces/list')->with('success', 'Annonce supprimée avec succès.');
    }
}
