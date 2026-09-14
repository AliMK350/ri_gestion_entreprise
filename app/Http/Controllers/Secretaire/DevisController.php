<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DevisController extends Controller
{
    public function list(Request $request)
    {
        $query = Quote::with(['client', 'seller'])->orderBy('created_at', 'desc');
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->where(function ($query) use ($search) {
                $query->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('seller', fn ($query) => $query->where('name', 'like', "%{$search}%"));
            });
        });
        $query->when($request->filled('status'), fn ($query) => $query->where('status', $request->status));
        $query->when($request->filled('date_from'), fn ($query) => $query->whereDate('quote_date', '>=', $request->date_from));
        $query->when($request->filled('date_to'), fn ($query) => $query->whereDate('quote_date', '<=', $request->date_to));

        $data['getRecord']    = $query->paginate(15)->withQueryString();
        $data['header_title'] = 'Gestion des Devis';
        return view('secretaire.devis.list', $data);
    }

    public function add()
    {
        $data['clients']      = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['sellers']      = User::where('is_delete', 0)->orderBy('name')->get();
        
        // Generate auto reference DEV-YYYY-XXXX
        $count = Quote::count() + 1;
        $data['auto_reference'] = 'DEV-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        
        $data['header_title'] = 'Nouveau Devis';
        return view('secretaire.devis.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'client_id'          => 'required|exists:clients,id',
            'reference'          => 'required|string|max:255',
            'quote_date'         => 'required|date',
            'seller_id'          => 'nullable|exists:users,id',
            'validity_date'      => 'nullable|string|max:255',
            'payment_conditions' => 'nullable|string',
            'notes'              => 'nullable|string',
            'status'             => 'required|in:draft,sent,accepted,rejected',
            'items'              => 'required|array|min:1',
            'items.*.designation'=> 'required|string|max:255',
            'items.*.quantity'   => 'required|numeric|min:0.01',
            'items.*.unit_price_ht' => 'required|numeric|min:0',
            'items.*.tva_rate'   => 'required|numeric|min:0',
        ]);

        $sellerId = $request->seller_id ?? Auth::id();

        $quote                     = new Quote;
        $quote->client_id          = $request->client_id;
        $quote->seller_id          = $sellerId;
        $quote->reference          = trim($request->reference);
        $quote->quote_date         = $request->quote_date;
        $quote->validity_date      = trim($request->validity_date);
        $quote->payment_conditions = trim($request->payment_conditions);
        $quote->notes              = trim($request->notes);
        $quote->status             = $request->status;
        $quote->details            = trim($request->notes);

        $totalHt  = 0;
        $totalTva = 0;

        $quote->total_ht     = 0;
        $quote->total_tva    = 0;
        $quote->total_ttc    = 0;
        $quote->total_amount = 0;
        $quote->save();

        foreach ($request->items as $itemData) {
            $qty         = floatval($itemData['quantity']);
            $unitPrice   = floatval($itemData['unit_price_ht']);
            $tvaRate     = floatval($itemData['tva_rate']);
            $unit        = $itemData['unit'] ?? 'Unité';

            $lineHt      = $qty * $unitPrice;
            $lineTva     = $lineHt * ($tvaRate / 100);
            $lineTtc     = $lineHt + $lineTva;

            $totalHt    += $lineHt;
            $totalTva   += $lineTva;

            $quoteItem                 = new QuoteItem;
            $quoteItem->quote_id       = $quote->id;
            $quoteItem->designation    = trim($itemData['designation']);
            $quoteItem->description    = isset($itemData['description']) ? trim($itemData['description']) : null;
            $quoteItem->quantity       = $qty;
            $quoteItem->unit           = trim($unit);
            $quoteItem->unit_price_ht  = $unitPrice;
            $quoteItem->tva_rate       = $tvaRate;
            $quoteItem->total_ht       = $lineHt;
            $quoteItem->total_tva      = $lineTva;
            $quoteItem->total_ttc      = $lineTtc;
            $quoteItem->save();
        }

        $totalTtc            = $totalHt + $totalTva;
        $quote->total_ht     = $totalHt;
        $quote->total_tva    = $totalTva;
        $quote->total_ttc    = $totalTtc;
        $quote->total_amount = $totalTtc;
        $quote->save();

        return redirect('secretaire/devis/list')->with('success', 'Devis créé avec succès.');
    }

    public function edit($id)
    {
        $data['getRecord']    = Quote::with('items')->findOrFail($id);
        $data['clients']      = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['sellers']      = User::where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Modifier le Devis';
        return view('secretaire.devis.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'client_id'          => 'required|exists:clients,id',
            'reference'          => 'required|string|max:255',
            'quote_date'         => 'required|date',
            'seller_id'          => 'nullable|exists:users,id',
            'validity_date'      => 'nullable|string|max:255',
            'payment_conditions' => 'nullable|string',
            'notes'              => 'nullable|string',
            'status'             => 'required|in:draft,sent,accepted,rejected',
            'items'              => 'required|array|min:1',
            'items.*.designation'=> 'required|string|max:255',
            'items.*.quantity'   => 'required|numeric|min:0.01',
            'items.*.unit_price_ht' => 'required|numeric|min:0',
            'items.*.tva_rate'   => 'required|numeric|min:0',
        ]);

        $quote                     = Quote::findOrFail($id);
        $quote->client_id          = $request->client_id;
        $quote->seller_id          = $request->seller_id ?? Auth::id();
        $quote->reference          = trim($request->reference);
        $quote->quote_date         = $request->quote_date;
        $quote->validity_date      = trim($request->validity_date);
        $quote->payment_conditions = trim($request->payment_conditions);
        $quote->notes              = trim($request->notes);
        $quote->status             = $request->status;
        $quote->details            = trim($request->notes);

        // Remove old items
        QuoteItem::where('quote_id', $quote->id)->delete();

        $totalHt  = 0;
        $totalTva = 0;

        foreach ($request->items as $itemData) {
            $qty         = floatval($itemData['quantity']);
            $unitPrice   = floatval($itemData['unit_price_ht']);
            $tvaRate     = floatval($itemData['tva_rate']);
            $unit        = $itemData['unit'] ?? 'Unité';

            $lineHt      = $qty * $unitPrice;
            $lineTva     = $lineHt * ($tvaRate / 100);
            $lineTtc     = $lineHt + $lineTva;

            $totalHt    += $lineHt;
            $totalTva   += $lineTva;

            $quoteItem                 = new QuoteItem;
            $quoteItem->quote_id       = $quote->id;
            $quoteItem->designation    = trim($itemData['designation']);
            $quoteItem->description    = isset($itemData['description']) ? trim($itemData['description']) : null;
            $quoteItem->quantity       = $qty;
            $quoteItem->unit           = trim($unit);
            $quoteItem->unit_price_ht  = $unitPrice;
            $quoteItem->tva_rate       = $tvaRate;
            $quoteItem->total_ht       = $lineHt;
            $quoteItem->total_tva      = $lineTva;
            $quoteItem->total_ttc      = $lineTtc;
            $quoteItem->save();
        }

        $totalTtc            = $totalHt + $totalTva;
        $quote->total_ht     = $totalHt;
        $quote->total_tva    = $totalTva;
        $quote->total_ttc    = $totalTtc;
        $quote->total_amount = $totalTtc;
        $quote->save();

        return redirect('secretaire/devis/list')->with('success', 'Devis mis à jour avec succès.');
    }

    public function delete($id)
    {
        Quote::findOrFail($id)->delete();
        return redirect('secretaire/devis/list')->with('success', 'Devis supprimé.');
    }

    public function pdf($id)
    {
        $quote = Quote::with(['client', 'seller', 'items'])->findOrFail($id);
        $pdf   = Pdf::loadView('secretaire.devis.pdf', ['quote' => $quote]);
        return $pdf->download(($quote->reference ?? ('devis-' . $id)) . '.pdf');
    }
}
