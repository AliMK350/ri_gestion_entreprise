<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    protected function getEmployee()
    {
        return Employee::forUser(Auth::id());
    }

    public function create()
    {
        $data['header_title'] = 'Demander un Congé';
        return view('employe.leaves.create', $data);
    }

    public function store(Request $request)
    {
        $employee = $this->getEmployee();
        if (!$employee) {
            return redirect('employe/absences')->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'type'       => 'required|in:vacation,sick,personal,other',
            'reason'     => 'nullable|string',
        ]);

        Leave::create([
            'employee_id' => $employee->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type,
            'reason'      => $request->reason,
            'status'      => 'pending',
        ]);

        return redirect('employe/absences')->with('success', 'Demande de congé envoyée');
    }
}
