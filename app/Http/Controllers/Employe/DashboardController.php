<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user     = Auth::user();
        $employee = Employee::forUser($user->id);

        $data = [
            'header_title'       => 'Espace Employé',
            'userType'           => $user->user_type,
            'employee'           => $employee,
            'my_absences'        => $employee ? $employee->absences()->count() : 0,
            'my_leaves'          => $employee ? $employee->leaves()->count() : 0,
            'pending_leaves'     => $employee ? $employee->leaves()->where('status', 'pending')->count() : 0,
            'leave_balance_days' => $employee ? ($employee->leave_balance_days ?? 0) : 0,
            'seniority_formatted'=> $employee ? $employee->seniority_formatted : 'Non renseignée',
            'seniority_months'   => $employee ? $employee->getSeniorityInMonths() : 0,
            'has_min_seniority'  => $employee ? $employee->hasMinimumSeniority(6) : false,
            'approved_leaves'    => $employee ? $employee->leaves()
                ->where('status', 'approved')
                ->where('start_date', '>', now()->toDateString())
                ->orderBy('start_date', 'asc')
                ->get() : collect(),
            'recent_leaves'      => $employee ? $employee->leaves()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get() : collect(),
        ];

        return view('employe.dashboard', $data);
    }
}
