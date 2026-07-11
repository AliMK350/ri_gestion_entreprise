<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LeaveDecisionMail;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Leave::getLeaves();
        $data['header_title'] = 'Gestion des Congés';
        return view('admin.leaves.list', $data);
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
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

        $leave->status = $request->status;
        $leave->save();

        try {
            $recipientEmail = null;

            if ($employee && $employee->user && !str_ends_with($employee->user->email, '@example.com')) {
                $recipientEmail = $employee->user->email;
            } elseif ($employee && !str_ends_with($employee->email, '@example.com')) {
                $recipientEmail = $employee->email;
            } elseif (!empty(env('LEAVE_EMPLOYEE_NOTIFICATION_EMAIL'))) {
                $recipientEmail = env('LEAVE_EMPLOYEE_NOTIFICATION_EMAIL');
            }

            if (!empty($recipientEmail)) {
                Mail::to($recipientEmail)->send(new LeaveDecisionMail($leave, $request->status));
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
