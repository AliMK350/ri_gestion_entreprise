<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DocumentRequestDecisionMail;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DocumentRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = DocumentRequest::with('employee')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);
                $query->whereHas('employee', fn ($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->when($request->filled('document_type'), fn ($query) => $query->where('document_type', 'like', '%' . trim($request->document_type) . '%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date_to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.document-requests.list', [
            'requests' => $requests,
            'header_title' => 'Demandes de documents',
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_response' => 'nullable|string|max:2000',
        ]);

        $documentRequest = DocumentRequest::findOrFail($id);
        $documentRequest->load('employee.user');
        $documentRequest->update([
            'status' => $data['status'],
            'admin_response' => $data['admin_response'] ?? null,
            'processed_at' => Carbon::now(),
        ]);

        $recipientEmails = array_values(array_unique(array_filter([
            $documentRequest->employee?->user?->email,
            $documentRequest->employee?->email,
        ])));

        try {
            foreach ($recipientEmails as $employeeEmail) {
                Mail::to($employeeEmail)->send(new DocumentRequestDecisionMail($documentRequest, $data['status']));
            }
        } catch (\Throwable $e) {
            Log::warning('Échec d\'envoi de la décision de demande de document à l\'employé.', [
                'exception' => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'La demande a été mise à jour.');
    }
}
