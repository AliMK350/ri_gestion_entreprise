<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestedMail;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    protected function getEmployee()
    {
        return Employee::forUser(Auth::id());
    }

    public function create()
    {
        $employee = $this->getEmployee();
        $data['header_title'] = 'Demander un Congé';
        $data['employee'] = $employee;
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

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $leaveModel = new Leave();

        if (!$leaveModel->hasSufficientBalance($employee, $startDate, $endDate)) {
            return redirect()->back()->with('error', 'Solde de congé insuffisant pour cette période.');
        }

        $leave = Leave::create([
            'employee_id' => $employee->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type,
            'reason'      => $request->reason,
            'status'      => 'pending',
        ]);

        $adminEmails = User::where('user_type', 1)
            ->where('is_delete', 0)
            ->whereNotNull('email')
            ->pluck('email');

        $configuredAdminEmail = env('LEAVE_ADMIN_NOTIFICATION_EMAIL');
        $recipientEmails = array_values(array_unique(array_filter([
            $configuredAdminEmail,
            ...$adminEmails->all(),
        ], function ($email) {
            return !empty($email) && !str_ends_with($email, '@example.com');
        })));

        try {
            foreach ($recipientEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new LeaveRequestedMail($leave));
            }
        } catch (\Throwable $e) {
            Log::warning('Échec d\'envoi de la notification de congé aux administrateurs.', [
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect('employe/absences')->with('success', 'Demande de congé envoyée');
    }
}
