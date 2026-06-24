<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Client::where('is_delete', 0)->orderBy('created_at', 'desc')->get();
        $data['header_title'] = 'Gestion des Clients';
        return view('secretaire.clients.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Ajouter un Client';
        return view('secretaire.clients.add', $data);
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
        $client->created_by   = Auth::user()->id;
        $client->save();

        return redirect('secretaire/clients/list')->with('success', 'Client créé avec succès.');
    }

    public function edit($id)
    {
        $data['getRecord'] = Client::where('id', $id)->where('is_delete', 0)->first();
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Modifier le Client';
        return view('secretaire.clients.edit', $data);
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

        $client = Client::where('id', $id)->where('is_delete', 0)->first();
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

        return redirect('secretaire/clients/list')->with('success', 'Client mis à jour.');
    }

    public function delete($id)
    {
        $client = Client::where('id', $id)->where('is_delete', 0)->first();
        if (empty($client)) {
            abort(404);
        }
        $client->is_delete = 1;
        $client->save();

        return redirect('secretaire/clients/list')->with('success', 'Client supprimé.');
    }

    public function show($id)
    {
        $data['getRecord'] = Client::with(['quotes', 'invoices'])->where('id', $id)->where('is_delete', 0)->first();
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Détails du Client';
        return view('secretaire.clients.show', $data);
    }
}
