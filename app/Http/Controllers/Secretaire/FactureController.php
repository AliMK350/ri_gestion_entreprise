<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Invoice::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Gestion des Factures';
        return view('secretaire.factures.list', $data);
    }

    public function add()
    {
        $data['clients']      = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['quotes']       = Quote::where('status', 'accepted')->with('client')->get();
        $data['header_title'] = 'Nouvelle Facture';
        return view('secretaire.factures.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'quote_id'   => 'nullable|exists:quotes,id',
            'reference'  => 'required|string|unique:invoices',
            'amount'     => 'required|numeric|min:0',
            'issued_at'  => 'required|date',
            'due_at'     => 'nullable|date|after_or_equal:issued_at',
            'details'    => 'nullable|string',
            'status'     => 'required|in:draft,sent,validated,cancelled',
        ]);

        $invoice             = new Invoice;
        $invoice->client_id  = $request->client_id;
        $invoice->quote_id   = $request->quote_id;
        $invoice->reference  = trim($request->reference);
        $invoice->amount     = $request->amount;
        $invoice->issued_at  = $request->issued_at;
        $invoice->due_at     = $request->due_at;
        $invoice->details    = $request->details;
        $invoice->status     = $request->status;
        $invoice->paid       = $request->status === 'validated';
        $invoice->save();

        return redirect('secretaire/factures/list')->with('success', 'Facture créée avec succès.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Invoice::findOrFail($id);
        $data['clients']   = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['quotes']    = Quote::where('status', 'accepted')->with('client')->get();
        $data['header_title'] = 'Modifier la Facture';
        return view('secretaire.factures.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'quote_id'   => 'nullable|exists:quotes,id',
            'reference'  => 'required|string|unique:invoices,reference,' . $id,
            'amount'     => 'required|numeric|min:0',
            'issued_at'  => 'required|date',
            'due_at'     => 'nullable|date|after_or_equal:issued_at',
            'details'    => 'nullable|string',
            'status'     => 'required|in:draft,sent,validated,cancelled',
        ]);

        $invoice             = Invoice::findOrFail($id);
        $invoice->client_id  = $request->client_id;
        $invoice->quote_id   = $request->quote_id;
        $invoice->reference  = trim($request->reference);
        $invoice->amount     = $request->amount;
        $invoice->issued_at  = $request->issued_at;
        $invoice->due_at     = $request->due_at;
        $invoice->details    = $request->details;
        $invoice->status     = $request->status;
        $invoice->paid       = $request->status === 'validated';
        $invoice->save();

        return redirect('secretaire/factures/list')->with('success', 'Facture mise à jour.');
    }

    public function delete($id)
    {
        Invoice::findOrFail($id)->delete();
        return redirect('secretaire/factures/list')->with('success', 'Facture supprimée.');
    }

    public function pdf($id)
    {
        $invoice = Invoice::with('client')->findOrFail($id);
        $pdf = Pdf::loadView('secretaire.factures.pdf', ['invoice' => $invoice]);
        return $pdf->download('facture-' . $invoice->reference . '.pdf');
    }
}
