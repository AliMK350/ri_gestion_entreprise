<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    private function prefix()
    {
        return request()->segment(1); // 'admin' or 'gerant'
    }

    public function list()
    {
        $prefix = $this->prefix();
        $data['getRecord']    = Invoice::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Validation des Factures';
        return view($prefix . '.factures.list', $data);
    }

    public function show($id)
    {
        $prefix = $this->prefix();
        $data['getRecord']    = Invoice::with(['client', 'quote'])->findOrFail($id);
        $data['header_title'] = 'Détail de la Facture';
        return view($prefix . '.factures.show', $data);
    }

    public function validateInvoice($id, Request $request)
    {
        $prefix = $this->prefix();
        $request->validate([
            'status' => 'required|in:validated,cancelled',
        ]);

        $invoice        = Invoice::findOrFail($id);
        $invoice->status = $request->status;
        $invoice->paid   = $request->status === 'validated';
        $invoice->save();

        return redirect($prefix . '/factures/list')->with('success', 'Facture mise à jour.');
    }

    public function delete($id)
    {
        $prefix = $this->prefix();
        Invoice::findOrFail($id)->delete();
        return redirect($prefix . '/factures/list')->with('success', 'Facture supprimée.');
    }
}
