<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Intern::getInterns();
        $data['header_title'] = 'Liste des Stagiaires';
        return view('admin.interns.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Ajouter un Stagiaire';
        return view('admin.interns.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:interns',
            'phone'      => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'cv_file'    => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'started_at' => 'nullable|date',
            'ended_at'   => 'nullable|date|after_or_equal:started_at',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('cvs', 'public');
        }

        $intern             = new Intern;
        $intern->name       = trim($request->name);
        $intern->email      = trim($request->email);
        $intern->phone      = trim($request->phone);
        $intern->department = trim($request->department);
        $intern->cv_path    = $cvPath;
        $intern->started_at = $request->started_at;
        $intern->ended_at   = $request->ended_at;
        $intern->save();

        return redirect('admin/interns/list')->with('success', 'Stagiaire créé avec succès');
    }

    public function edit($id)
    {
        $data['getRecord'] = Intern::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Modifier le Stagiaire';
        return view('admin.interns.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:interns,email,' . $id,
            'phone'      => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'cv_file'    => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'started_at' => 'nullable|date',
            'ended_at'   => 'nullable|date|after_or_equal:started_at',
        ]);

        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }

        if ($request->hasFile('cv_file')) {
            if (!empty($intern->cv_path) && Storage::disk('public')->exists($intern->cv_path)) {
                Storage::disk('public')->delete($intern->cv_path);
            }
            $intern->cv_path = $request->file('cv_file')->store('cvs', 'public');
        }

        $intern->name       = trim($request->name);
        $intern->email      = trim($request->email);
        $intern->phone      = trim($request->phone);
        $intern->department = trim($request->department);
        $intern->started_at = $request->started_at;
        $intern->ended_at   = $request->ended_at;
        $intern->save();

        return redirect('admin/interns/list')->with('success', 'Stagiaire mis à jour avec succès');
    }

    public function delete($id)
    {
        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }
        $intern->delete();

        return redirect('admin/interns/list')->with('success', 'Stagiaire supprimé avec succès');
    }
}
