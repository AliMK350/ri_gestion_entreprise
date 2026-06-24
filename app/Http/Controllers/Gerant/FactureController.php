<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Invoice::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Validation des Factures';
        return view('gerant.factures.list', $data);
    }

    public function validateInvoice($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:validated,cancelled',
        ]);

        $invoice       = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->paid   = $request->status === 'validated';
        $invoice->save();

        return redirect('gerant/factures/list')->with('success', 'Facture mise à jour.');
    }

    public function delete($id)
    {
        Invoice::findOrFail($id)->delete();
        return redirect('gerant/factures/list')->with('success', 'Facture supprimée.');
    }
}
