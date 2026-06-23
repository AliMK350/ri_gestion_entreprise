<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Gestion des Notes';
        $data['notes'] = Note::select('notes.*', 'users.name as student_name', 'modules.nom as module_name')
            ->join('users', 'users.id', '=', 'notes.student_id')
            ->join('modules', 'modules.id', '=', 'notes.module_id')
            ->orderBy('notes.id', 'desc')
            ->get();

        return view('admin.notes.index', $data);
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->back()->with('success', 'Note supprimée avec succès.');
    }
}
