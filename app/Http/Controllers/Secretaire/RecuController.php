<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RecuController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Receipt::with(['client', 'invoice'])->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Gestion des Reçus';
        return view('secretaire.recus.list', $data);
    }

    public function add()
    {
        $data['clients']      = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['invoices']     = Invoice::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Nouveau Reçu';
        return view('secretaire.recus.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'invoice_id'     => 'required|exists:invoices,id',
            'amount'         => 'required|numeric|min:0',
            'paid_at'        => 'required|date',
            'payment_method' => 'nullable|string|max:100',
        ]);

        $receipt                  = new Receipt;
        $receipt->client_id       = $request->client_id;
        $receipt->invoice_id      = $request->invoice_id;
        $receipt->amount          = $request->amount;
        $receipt->paid_at         = $request->paid_at;
        $receipt->payment_method  = $request->payment_method;
        $receipt->save();

        $invoice       = Invoice::find($request->invoice_id);
        $invoice->paid = true;
        $invoice->status = 'validated';
        $invoice->save();

        return redirect('secretaire/recus/list')->with('success', 'Reçu enregistré avec succès.');
    }

    public function delete($id)
    {
        Receipt::findOrFail($id)->delete();
        return redirect('secretaire/recus/list')->with('success', 'Reçu supprimé.');
    }

    public function pdf($id)
    {
        $receipt = Receipt::with(['client', 'invoice'])->findOrFail($id);
        $pdf = Pdf::loadView('secretaire.recus.pdf', ['receipt' => $receipt]);
        return $pdf->download('recu-' . $receipt->id . '.pdf');
    }
}
