<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Intern;
use App\Models\Invoice;
use App\Models\Leave;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        $data = [
            'header_title'    => 'Tableau de bord',
            'userType'        => $user->user_type,
            'total_employees' => Employee::where('status', 0)->count(),
            'total_interns'   => Intern::count(),
            'total_clients'   => Client::where('is_delete', 0)->count(),
            'total_quotes'    => Quote::count(),
            'total_invoices'  => Invoice::count(),
            'pending_leaves'  => Leave::where('status', 'pending')->count(),
        ];

        if ($user->user_type == 1) {
            return view('admin.dashboard', $data);
        }

        return redirect('/');
    }
}
