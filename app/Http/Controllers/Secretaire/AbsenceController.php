<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Gestion des absences';
        $data['absences'] = Absence::where('created_by', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.absences.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Enregistrer une absence';
        $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.absences.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'date' => 'required|date',
            'justifiee' => 'required|in:0,1',
            'motif' => 'nullable|string|max:255',
        ]);

        Absence::create([
            'student_id' => $request->student_id,
            'subject_name' => $request->subject_name,
            'date' => $request->date,
            'justifiee' => $request->justifiee,
            'motif' => $request->motif,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.absences.index')->with('success', 'Absence enregistree avec succes.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Absence::where('created_by', Auth::id())->findOrFail($id);
        $data['header_title'] = 'Modifier une absence';
        $data['students'] = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.absences.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'date' => 'required|date',
            'justifiee' => 'required|in:0,1',
            'motif' => 'nullable|string|max:255',
        ]);

        $absence = Absence::where('created_by', Auth::id())->findOrFail($id);
        $absence->update([
            'student_id' => $request->student_id,
            'subject_name' => $request->subject_name,
            'date' => $request->date,
            'justifiee' => $request->justifiee,
            'motif' => $request->motif,
        ]);

        return redirect()->route('teacher.absences.index')->with('success', 'Absence mise a jour avec succes.');
    }
}
