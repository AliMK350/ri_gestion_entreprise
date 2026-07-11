<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    protected function getEmployee()
    {
        return Employee::forUser(Auth::id());
    }

    public function index()
    {
        $employee = $this->getEmployee();
        $data['absences']     = $employee ? $employee->absences()->orderBy('date', 'desc')->get() : collect();
        $data['leaves']       = $employee ? $employee->leaves()->orderBy('start_date', 'desc')->get() : collect();
        $data['employee']     = $employee;
        $data['header_title'] = 'Mes Absences & Congés';
        return view('employe.absences.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Déclarer une Absence';
        return view('employe.absences.create', $data);
    }

    public function store(Request $request)
    {
        $employee = $this->getEmployee();
        if (!$employee) {
            return redirect('employe/absences')->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $request->validate([
            'date'   => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        Absence::create([
            'employee_id' => $employee->id,
            'date'        => $request->date,
            'reason'      => $request->reason,
        ]);

        return redirect('employe/absences')->with('success', 'Absence déclarée avec succès');
    }
}
