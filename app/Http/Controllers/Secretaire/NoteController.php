<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Saisie des notes';
        $data['notes'] = Note::where('created_by', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.notes.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Ajouter une note';
        $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.notes.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'valeur' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|numeric|min:0.1',
            'session' => 'nullable|string|max:255',
        ]);

        Note::create([
            'student_id' => $request->student_id,
            'subject_name' => $request->subject_name,
            'valeur' => $request->valeur,
            'coefficient' => $request->coefficient,
            'session' => $request->session,
            'created_by' => Auth::id(),
            'status' => 0,
        ]);

        return redirect()->route('teacher.notes.index')->with('success', 'Note enregistree avec succes.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Note::where('created_by', Auth::id())->findOrFail($id);
        $data['header_title'] = 'Modifier une note';
        $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.notes.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'valeur' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|numeric|min:0.1',
            'session' => 'nullable|string|max:255',
        ]);

        $note = Note::where('created_by', Auth::id())->findOrFail($id);
        $note->update([
            'student_id' => $request->student_id,
            'subject_name' => $request->subject_name,
            'valeur' => $request->valeur,
            'coefficient' => $request->coefficient,
            'session' => $request->session,
        ]);

        return redirect()->route('teacher.notes.index')->with('success', 'Note mise a jour avec succes.');
    }
}
