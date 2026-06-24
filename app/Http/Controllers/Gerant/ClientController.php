<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Client::getClients();
        $data['header_title'] = 'Gestion des Clients';
        return view('gerant.clients.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Ajouter un Client';
        return view('gerant.clients.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:clients',
            'company_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'address'      => 'nullable|string',
            'status'       => 'required',
        ]);

        $client               = new Client;
        $client->name         = trim($request->name);
        $client->email        = trim($request->email);
        $client->company_name = trim($request->company_name);
        $client->phone        = trim($request->phone);
        $client->address      = trim($request->address);
        $client->status       = intval($request->status);
        $client->created_by   = auth()->id();
        $client->save();

        return redirect('gerant/clients/list')->with('success', 'Client créé avec succès.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Client::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Modifier le Client';
        return view('gerant.clients.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:clients,email,' . $id,
            'company_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'address'      => 'nullable|string',
            'status'       => 'required',
        ]);

        $client = Client::getSingle($id);
        if (empty($client)) {
            abort(404);
        }

        $client->name         = trim($request->name);
        $client->email        = trim($request->email);
        $client->company_name = trim($request->company_name);
        $client->phone        = trim($request->phone);
        $client->address      = trim($request->address);
        $client->status       = intval($request->status);
        $client->save();

        return redirect('gerant/clients/list')->with('success', 'Client mis à jour.');
    }

    public function delete($id)
    {
        $client = Client::getSingle($id);
        if (empty($client)) {
            abort(404);
        }
        $client->is_delete = 1;
        $client->save();

        return redirect('gerant/clients/list')->with('success', 'Client supprimé.');
    }

    public function history($id)
    {
        $client = Client::with(['quotes', 'invoices', 'receipts'])->findOrFail($id);
        $data['getRecord']    = $client;
        $data['header_title'] = 'Historique Client';
        return view('gerant.clients.history', $data);
    }
}
