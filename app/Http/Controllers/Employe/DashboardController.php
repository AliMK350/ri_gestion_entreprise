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
            'header_title'    => 'Espace Employé',
            'userType'        => $user->user_type,
            'my_absences'     => $employee ? $employee->absences()->count() : 0,
            'my_leaves'       => $employee ? $employee->leaves()->count() : 0,
            'pending_leaves'  => $employee ? $employee->leaves()->where('status', 'pending')->count() : 0,
        ];

        return view('employe.dashboard', $data);
    }
}
