<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    private function prefix()
    {
        return request()->segment(1); // 'admin' or 'gerant'
    }

    public function list()
    {
        $prefix = $this->prefix();
        $data['getRecord']    = Quote::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Validation des Devis';
        return view($prefix . '.devis.list', $data);
    }

    public function show($id)
    {
        $prefix = $this->prefix();
        $data['getRecord']    = Quote::with(['client', 'seller', 'items'])->findOrFail($id);
        $data['header_title'] = 'Détail du Devis';
        return view($prefix . '.devis.show', $data);
    }

    public function validateQuote($id, Request $request)
    {
        $prefix = $this->prefix();
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $quote         = Quote::findOrFail($id);
        $quote->status = $request->status;
        $quote->save();

        return redirect($prefix . '/devis/list')->with('success', 'Devis ' . ($request->status === 'accepted' ? 'validé' : 'refusé') . '.');
    }

    public function delete($id)
    {
        $prefix = $this->prefix();
        Quote::findOrFail($id)->delete();
        return redirect($prefix . '/devis/list')->with('success', 'Devis supprimé.');
    }
}
