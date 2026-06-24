<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Quote::with('client')->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Validation des Devis';
        return view('gerant.devis.list', $data);
    }

    public function validateQuote($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $quote         = Quote::findOrFail($id);
        $quote->status = $request->status;
        $quote->save();

        return redirect('gerant/devis/list')->with('success', 'Devis ' . ($request->status === 'accepted' ? 'validé' : 'refusé') . '.');
    }

    public function delete($id)
    {
        Quote::findOrFail($id)->delete();
        return redirect('gerant/devis/list')->with('success', 'Devis supprimé.');
    }
}
