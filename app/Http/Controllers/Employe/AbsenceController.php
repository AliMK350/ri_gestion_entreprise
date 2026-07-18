<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ManagesPersonnelAbsencesAndLeaves;
use App\Models\Absence;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
    use ManagesPersonnelAbsencesAndLeaves;

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
            return redirect($this->personnelUrl('absences'))->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $request->validate([
            'date'   => 'required|date',
            'half_day' => 'nullable|in:morning,afternoon',
            'reason' => 'nullable|string|max:255',
            'justification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('justification_file')) {
            $filePath = $request->file('justification_file')->store('justifications', 'public');
        }

        Absence::create([
            'employee_id'        => $employee->id,
            'declared_by'        => 'employee',
            'date'               => $request->date,
            'half_day'           => $request->half_day,
            'reason'             => $request->reason,
            'justification_file' => $filePath,
        ]);

        return redirect($this->personnelUrl('absences'))->with('success', 'Absence déclarée avec succès');
    }

    public function edit($id)
    {
        $employee = $this->getEmployee();
        if (!$employee) {
            return redirect($this->personnelUrl('absences'))->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $absence = Absence::where('id', $id)
            ->where('employee_id', $employee->id)
            ->where('declared_by', 'admin')
            ->firstOrFail();

        $data['absence']      = $absence;
        $data['header_title'] = 'Justifier une absence';
        return view('employe.absences.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $employee = $this->getEmployee();
        if (!$employee) {
            return redirect($this->personnelUrl('absences'))->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $absence = Absence::where('id', $id)
            ->where('employee_id', $employee->id)
            ->where('declared_by', 'admin')
            ->firstOrFail();

        $rules = [
            'reason' => 'required|string|max:255',
        ];

        if (empty($absence->justification_file)) {
            $rules['justification_file'] = 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048';
        } else {
            $rules['justification_file'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048';
        }

        $request->validate($rules);

        if ($request->hasFile('justification_file')) {
            if ($absence->justification_file) {
                Storage::disk('public')->delete($absence->justification_file);
            }
            $absence->justification_file = $request->file('justification_file')->store('justifications', 'public');
        }

        $absence->reason = $request->reason;
        $absence->save();

        return redirect($this->personnelUrl('absences'))->with('success', 'Motif et justificatif enregistrés avec succès');
    }
}
