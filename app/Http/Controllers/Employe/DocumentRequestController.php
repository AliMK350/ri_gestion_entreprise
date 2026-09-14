<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Mail\DocumentRequestCreatedMail;
use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403);

        return view('employe.document-requests.list', [
            'requests' => $employee->documentRequests()->latest()->get(),
            'documentTypes' => DocumentRequest::TYPES,
            'header_title' => 'Demandes de documents administratifs',
        ]);
    }

    public function store(Request $request)
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 403);

        $data = $request->validate([
            'document_type' => ['required', 'in:' . implode(',', DocumentRequest::TYPES)],
            'reason' => 'nullable|string|max:2000',
        ]);
        $data['employee_id'] = $employee->id;
        $documentRequest = DocumentRequest::create($data);
        $documentRequest->load('employee');

        $adminEmails = User::where('user_type', 1)
            ->where('is_delete', 0)
            ->whereNotNull('email')
            ->pluck('email');
        $recipientEmails = array_values(array_unique(array_filter([
            env('DOCUMENT_REQUEST_ADMIN_NOTIFICATION_EMAIL', env('LEAVE_ADMIN_NOTIFICATION_EMAIL')),
            ...$adminEmails->all(),
        ], fn ($email) => !empty($email) && !str_ends_with($email, '@example.com'))));

        try {
            foreach ($recipientEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new DocumentRequestCreatedMail($documentRequest));
            }
        } catch (\Throwable $e) {
            Log::warning('Échec d\'envoi de la notification de demande de document aux administrateurs.', [
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Votre demande a été envoyée au directeur.');
    }
}
