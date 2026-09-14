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

    public function list(Request $request)
    {
        $prefix = $this->prefix();
        $query = Quote::with('client')->orderBy('created_at', 'desc');

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
        $query->when($request->filled('date_from'), fn ($query) => $query->whereDate('quote_date', '>=', $request->date_from));
        $query->when($request->filled('date_to'), fn ($query) => $query->whereDate('quote_date', '<=', $request->date_to));

        $data['getRecord']    = $query->paginate(15)->withQueryString();
        $data['header_title'] = 'Validation des Devis';
        $data['prefix']       = $prefix;
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
