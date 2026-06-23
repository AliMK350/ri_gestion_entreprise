<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Emploi du Temps';
        $data['emplois'] = EmploiDuTemps::select('emplois_du_temps.*', 'class.name as class_name', 'users.name as teacher_name')
            ->leftJoin('class', 'class.id', '=', 'emplois_du_temps.class_id')
            ->leftJoin('users', 'users.id', '=', 'emplois_du_temps.teacher_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.emploi-du-temps.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Ajouter une séance';
        $data['classes'] = ClassModel::where('is_delete', 0)->orderBy('name')->get();
        $data['teachers'] = User::where('user_type', 2)->where('is_delete', 0)->orderBy('name')->get();

        return view('admin.emploi-du-temps.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'teacher_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'jour' => 'required|string|max:255',
            'heure' => 'required|string|max:255',
            'salle' => 'required|string|max:255',
        ]);

        EmploiDuTemps::create([
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
            'subject_name' => $request->subject_name,
            'jour' => $request->jour,
            'heure' => $request->heure,
            'salle' => $request->salle,
        ]);

        return redirect('admin/emploi-du-temps/list')->with('success', 'Séance ajoutée avec succès.');
    }

    public function edit($id)
    {
        $data['emploi'] = EmploiDuTemps::findOrFail($id);
        $data['header_title'] = 'Modifier une séance';
        $data['classes'] = ClassModel::where('is_delete', 0)->orderBy('name')->get();
        $data['teachers'] = User::where('user_type', 2)->where('is_delete', 0)->orderBy('name')->get();

        return view('admin.emploi-du-temps.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $emploi = EmploiDuTemps::findOrFail($id);

        $request->validate([
            'class_id' => 'required|exists:class,id',
            'teacher_id' => 'required|exists:users,id',
            'subject_name' => 'required|string|max:255',
            'jour' => 'required|string|max:255',
            'heure' => 'required|string|max:255',
            'salle' => 'required|string|max:255',
        ]);

        $emploi->update([
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
            'subject_name' => $request->subject_name,
            'jour' => $request->jour,
            'heure' => $request->heure,
            'salle' => $request->salle,
        ]);

        return redirect('admin/emploi-du-temps/list')->with('success', 'Séance mise à jour avec succès.');
    }

    public function delete($id)
    {
        $emploi = EmploiDuTemps::findOrFail($id);
        $emploi->delete();

        return redirect('admin/emploi-du-temps/list')->with('success', 'Séance supprimée avec succès.');
    }
}
