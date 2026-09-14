<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function list(Request $request)
    {
        $query = Absence::with('employee')->orderBy('date', 'desc');
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->whereHas('employee', fn ($query) => $query->where('name', 'like', "%{$search}%"));
        });
        $query->when($request->filled('half_day'), $request->half_day === 'full' ? fn ($query) => $query->whereNull('half_day') : fn ($query) => $query->where('half_day', $request->half_day));
        $query->when($request->filled('declared_by'), fn ($query) => $query->where('declared_by', $request->declared_by));
        $query->when($request->filled('justification'), $request->justification === 'yes' ? fn ($query) => $query->whereNotNull('justification_file') : fn ($query) => $query->whereNull('justification_file'));
        $query->when($request->filled('reason'), $request->reason === 'yes' ? fn ($query) => $query->whereNotNull('reason')->where('reason', '!=', '') : fn ($query) => $query->where(function ($query) { $query->whereNull('reason')->orWhere('reason', ''); }));
        $query->when($request->filled('date_from'), fn ($query) => $query->whereDate('date', '>=', $request->date_from));
        $query->when($request->filled('date_to'), fn ($query) => $query->whereDate('date', '<=', $request->date_to));
        $data['employees'] = Employee::where('status', 0)->orderBy('name')->get(['id', 'name']);
        $query->when($request->filled('employee_id'), fn ($query) => $query->where('employee_id', $request->employee_id));
        $sort = in_array($request->get('sort'), ['date', 'created_at'], true) ? $request->get('sort') : 'date';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $data['getRecord']    = $query->orderBy($sort, $direction)->paginate(15)->withQueryString();
        $data['header_title'] = 'Gestion des Absences';
        return view('admin.absences.list', $data);
    }

    public function add()
    {
        // Récupérer tous les employés actifs : ceux liés à un utilisateur
        // non-admin (secrétaires, employés, gérants) + ceux sans compte utilisateur
        $data['employees'] = Employee::with('user')
            ->where('status', 0)
            ->where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('user_type', '!=', 1)
                      ->where('is_delete', 0);
                })
                ->orWhereNull('user_id');
            })
            ->orderBy('name')
            ->get();
        $data['header_title'] = 'Déclarer une Absence';
        return view('admin.absences.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'half_day'    => 'nullable|in:morning,afternoon',
            'reason'      => 'nullable|string|max:255',
        ]);

        $absence               = new Absence;
        $absence->employee_id  = $request->employee_id;
        $absence->declared_by  = 'admin';
        $absence->date         = $request->date;
        $absence->half_day     = $request->half_day;
        $absence->reason       = $request->reason;
        $absence->save();

        return redirect('admin/absences/list')->with('success', 'Absence enregistrée avec succès');
    }

    public function delete($id)
    {
        Absence::findOrFail($id)->delete();
        return redirect('admin/absences/list')->with('success', 'Absence supprimée');
    }
}
