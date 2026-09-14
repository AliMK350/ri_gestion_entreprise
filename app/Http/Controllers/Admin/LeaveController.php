<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LeaveDecisionMail;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    public function list(Request $request)
    {
        $query = Leave::with('employee')->orderBy('created_at', 'desc');
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->whereHas('employee', fn ($query) => $query->where('name', 'like', "%{$search}%"));
        });
        $query->when($request->filled('status'), fn ($query) => $query->where('status', $request->status));
        $query->when($request->filled('type'), fn ($query) => $query->where('type', $request->type));
        $query->when($request->filled('date_from'), fn ($query) => $query->whereDate('start_date', '>=', $request->date_from));
        $query->when($request->filled('date_to'), fn ($query) => $query->whereDate('end_date', '<=', $request->date_to));
        $data['getRecord']    = $query->paginate(10)->withQueryString();
        $data['header_title'] = 'Gestion des Congés';
        return view('admin.leaves.list', $data);
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        $leave = Leave::findOrFail($id);
        $employee = $leave->employee;

        if ($request->status === 'approved' && $leave->status !== 'approved') {
            $leaveModel = new Leave();
            if (!$leaveModel->hasSufficientBalance($employee, $leave->start_date, $leave->end_date)) {
                return redirect()->back()->with('error', 'Le solde de congé est insuffisant pour approuver cette demande.');
            }

            $employee->leave_balance_days = max(0, (int) $employee->leave_balance_days - $leaveModel->calculateWorkingDays($leave->start_date, $leave->end_date));
            $employee->save();
        }

        if ($leave->status === 'approved' && $request->status === 'cancelled') {
            $leaveModel = new Leave();
            $employee->leave_balance_days = (int) $employee->leave_balance_days + $leaveModel->calculateWorkingDays($leave->start_date, $leave->end_date);
            $employee->save();
        }

        $leave->status = $request->status;
        $leave->save();

        try {
            $recipientEmails = [];

            if ($employee && $employee->user && !str_ends_with($employee->user->email, '@example.com')) {
                $recipientEmails[] = $employee->user->email;
            } elseif ($employee && !str_ends_with($employee->email, '@example.com')) {
                $recipientEmails[] = $employee->email;
            } elseif (!empty(env('LEAVE_EMPLOYEE_NOTIFICATION_EMAIL'))) {
                $recipientEmails[] = env('LEAVE_EMPLOYEE_NOTIFICATION_EMAIL');
            }

            if ($request->status === 'cancelled') {
                $adminEmails = User::where('user_type', 1)
                    ->where('is_delete', 0)
                    ->whereNotNull('email')
                    ->pluck('email');

                $configuredAdminEmail = env('LEAVE_ADMIN_NOTIFICATION_EMAIL');
                $recipientEmails = array_values(array_unique(array_merge(
                    $recipientEmails,
                    array_filter([
                        $configuredAdminEmail,
                        ...$adminEmails->all(),
                    ], fn ($email) => !empty($email) && !str_ends_with($email, '@example.com'))
                )));
            }

            $recipientEmails = array_values(array_unique(array_filter($recipientEmails, fn ($email) => !empty($email))));

            if (!empty($recipientEmails)) {
                foreach ($recipientEmails as $recipientEmail) {
                    Mail::to($recipientEmail)->send(new LeaveDecisionMail($leave, $request->status));
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Échec d\'envoi du mail de décision de congé.', [
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect('admin/leaves/list')->with('success', 'Statut du congé mis à jour');
    }

    public function delete($id)
    {
        Leave::findOrFail($id)->delete();
        return redirect('admin/leaves/list')->with('success', 'Congé supprimé');
    }
}
