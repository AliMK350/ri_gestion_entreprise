<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Absence::with('employee')->orderBy('date', 'desc')->paginate(15);
        $data['header_title'] = 'Gestion des Absences';
        return view('admin.absences.list', $data);
    }

    public function add()
    {
        $data['employees']    = Employee::where('status', 0)->orderBy('name')->get();
        $data['header_title'] = 'Déclarer une Absence';
        return view('admin.absences.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'reason'      => 'nullable|string|max:255',
        ]);

        $absence              = new Absence;
        $absence->employee_id = $request->employee_id;
        $absence->date        = $request->date;
        $absence->reason      = $request->reason;
        $absence->save();

        return redirect('admin/absences/list')->with('success', 'Absence enregistrée avec succès');
    }

    public function delete($id)
    {
        Absence::findOrFail($id)->delete();
        return redirect('admin/absences/list')->with('success', 'Absence supprimée');
    }
}
