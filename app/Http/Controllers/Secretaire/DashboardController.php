<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $employee = Employee::forUser($user->id);

        $data = [
            'header_title'    => 'Espace Secrétaire',
            'userType'        => $user->user_type,
            'total_clients'   => Client::where('is_delete', 0)->count(),
            'total_quotes'    => Quote::count(),
            'total_invoices'  => Invoice::count(),
            'my_absences'     => $employee ? $employee->absences()->count() : 0,
            'my_leaves'       => $employee ? $employee->leaves()->count() : 0,
            'pending_leaves'  => $employee ? $employee->leaves()->where('status', 'pending')->count() : 0,
        ];

        return view('secretaire.dashboard', $data);
    }
}
