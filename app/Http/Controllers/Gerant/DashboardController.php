<?php

namespace App\Http\Controllers\Gerant;

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

        $data = [
            'header_title'    => 'Espace Gérant',
            'userType'        => $user->user_type,
            'total_clients'   => Client::where('is_delete', 0)->count(),
            'total_employees' => Employee::where('status', 0)->count(),
            'total_quotes'    => Quote::count(),
            'total_invoices'  => Invoice::count(),
            'pending_quotes'  => Quote::whereIn('status', ['draft', 'sent'])->count(),
        ];

        return view('gerant.dashboard', $data);
    }
}
