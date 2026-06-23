<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Gestion des Absences';
        $data['absences'] = Absence::select('absences.*', 'users.name as student_name')
            ->join('users', 'users.id', '=', 'absences.student_id')
            ->orderBy('absences.id', 'desc')
            ->get();

        return view('admin.absences.index', $data);
    }

    public function delete($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->back()->with('success', 'Absence supprimée avec succès.');
    }
}
