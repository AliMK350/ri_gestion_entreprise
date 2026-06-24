<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DevisController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Quote::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Gestion des Devis';
        return view('secretaire.devis.list', $data);
    }

    public function add()
    {
        $data['clients']      = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Nouveau Devis';
        return view('secretaire.devis.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'details'      => 'nullable|string',
            'status'       => 'required|in:draft,sent,accepted,rejected',
        ]);

        $quote               = new Quote;
        $quote->client_id    = $request->client_id;
        $quote->employee_id  = null;
        $quote->total_amount = $request->total_amount;
        $quote->status       = $request->status;
        $quote->details      = $request->details;
        $quote->save();

        return redirect('secretaire/devis/list')->with('success', 'Devis créé avec succès.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Quote::findOrFail($id);
        $data['clients']   = Client::where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Modifier le Devis';
        return view('secretaire.devis.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'details'      => 'nullable|string',
            'status'       => 'required|in:draft,sent,accepted,rejected',
        ]);

        $quote               = Quote::findOrFail($id);
        $quote->client_id    = $request->client_id;
        $quote->total_amount = $request->total_amount;
        $quote->status       = $request->status;
        $quote->details      = $request->details;
        $quote->save();

        return redirect('secretaire/devis/list')->with('success', 'Devis mis à jour.');
    }

    public function delete($id)
    {
        Quote::findOrFail($id)->delete();
        return redirect('secretaire/devis/list')->with('success', 'Devis supprimé.');
    }

    public function pdf($id)
    {
        $quote = Quote::with('client')->findOrFail($id);
        $pdf = Pdf::loadView('secretaire.devis.pdf', ['quote' => $quote]);
        return $pdf->download('devis-' . $id . '.pdf');
    }
}
