<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ManagesPersonnelAbsencesAndLeaves;
use App\Mail\LeaveDecisionMail;
use App\Mail\LeaveRequestedMail;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    use ManagesPersonnelAbsencesAndLeaves;

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
            return redirect($this->personnelUrl('absences'))->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'type'       => 'required|in:vacation,sick,personal,other,death,marriage',
            'reason'     => 'nullable|string',
            'justification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $hasJustification = $request->hasFile('justification_file');
        if (!$employee->canRequestLeaveType($request->type, $hasJustification, $request->reason)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'En tant qu\'employé de moins de 6 mois d\'ancienneté, vous n\'êtes pas autorisé à demander un congé normal (congé payé). Seuls les cas spéciaux (décès, mariage, maladie, ou cas exceptionnel avec justificatif) sont autorisés.');
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $leaveModel = new Leave();

        if (!$leaveModel->hasSufficientBalance($employee, $startDate, $endDate)) {
            return redirect()->back()->with('error', 'Solde de congé insuffisant pour cette période.');
        }

        $filePath = null;
        if ($request->hasFile('justification_file')) {
            $filePath = $request->file('justification_file')->store('justifications', 'public');
        }

        $leave = Leave::create([
            'employee_id' => $employee->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type,
            'reason'      => $request->reason,
            'justification_file' => $filePath,
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

        return redirect($this->personnelUrl('absences'))->with('success', 'Demande de congé envoyée');
    }

    public function cancel($id)
    {
        $employee = $this->getEmployee();

        if (!$employee) {
            return redirect($this->personnelUrl('absences'))->with('error', 'Aucun profil employé associé à votre compte.');
        }

        $leave = Leave::where('id', $id)->where('employee_id', $employee->id)->firstOrFail();

        if ($leave->status !== 'approved') {
            return redirect($this->personnelUrl('absences'))->with('error', 'Seuls les congés approuvés peuvent être annulés.');
        }

        $startDate = Carbon::parse($leave->start_date);
        $today = Carbon::today();

        if ($startDate->lte($today)) {
            return redirect($this->personnelUrl('absences'))->with('error', 'Vous ne pouvez annuler un congé qu\'avant son début.');
        }

        $daysToRefund = (new Leave())->calculateWorkingDays($startDate, $leave->end_date);
        $employee->leave_balance_days = (int) $employee->leave_balance_days + $daysToRefund;
        $employee->save();

        $leave->status = 'cancelled';
        $leave->save();

        $adminEmails = User::where('user_type', 1)
            ->where('is_delete', 0)
            ->whereNotNull('email')
            ->pluck('email');

        $configuredAdminEmail = env('LEAVE_ADMIN_NOTIFICATION_EMAIL');
        $recipientEmails = array_values(array_unique(array_filter([
            $employee->user?->email,
            $employee->email,
            $configuredAdminEmail,
            ...$adminEmails->all(),
        ], fn ($email) => !empty($email) && !str_ends_with($email, '@example.com'))));

        try {
            foreach ($recipientEmails as $recipientEmail) {
                Mail::to($recipientEmail)->send(new LeaveDecisionMail($leave, 'cancelled'));
            }
        } catch (\Throwable $e) {
            Log::warning('Échec d\'envoi du mail d\'annulation de congé.', [
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect($this->personnelUrl('absences'))->with('success', 'Congé annulé avec remboursement des jours non commencés.');
    }
}
