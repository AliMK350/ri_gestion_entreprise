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

    public function list(Request $request)
    {
        $prefix = $this->prefix();
        $query = Invoice::with('client')->orderBy('created_at', 'desc');

        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->where(function ($query) use ($search) {
                $query->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%");
                    });
            });
        });
        $query->when($request->filled('status'), fn ($query) => $query->where('status', $request->status));
        $query->when($request->filled('paid'), fn ($query) => $query->where('paid', $request->paid));
        $query->when($request->filled('date_from'), fn ($query) => $query->whereDate('issued_at', '>=', $request->date_from));
        $query->when($request->filled('date_to'), fn ($query) => $query->whereDate('issued_at', '<=', $request->date_to));

        $data['getRecord']    = $query->paginate(15)->withQueryString();
        $data['header_title'] = 'Validation des Factures';
        $data['prefix']       = $prefix;
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
