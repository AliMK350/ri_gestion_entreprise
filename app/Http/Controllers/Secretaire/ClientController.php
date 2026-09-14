<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function list(Request $request)
    {
        $query = Client::where('is_delete', 0)->orderBy('created_at', 'desc');
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        });
        $query->when($request->filled('client_type'), fn ($query) => $query->where('client_type', $request->client_type));
        $data['getRecord']    = $query->paginate(15)->withQueryString();
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
            'client_type'  => 'required|in:entreprise,personne',
            'company_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'city'         => 'nullable|string|max:255',
            'address'      => 'nullable|string',
        ]);

        $client               = new Client;
        $client->name         = trim($request->name);
        $client->email        = trim($request->email);
        $client->client_type  = $request->client_type;
        $client->company_name = trim($request->company_name);
        $client->phone        = trim($request->phone);
        $client->city         = trim($request->city);
        $client->address      = trim($request->address);
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
            'client_type'  => 'required|in:entreprise,personne',
            'company_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'city'         => 'nullable|string|max:255',
            'address'      => 'nullable|string',
        ]);

        $client = Client::where('id', $id)->where('is_delete', 0)->first();
        if (empty($client)) {
            abort(404);
        }

        $client->name         = trim($request->name);
        $client->email        = trim($request->email);
        $client->client_type  = $request->client_type;
        $client->company_name = trim($request->company_name);
        $client->phone        = trim($request->phone);
        $client->city         = trim($request->city);
        $client->address      = trim($request->address);
        $client->save();

        return redirect('secretaire/clients/list')->with('success', 'Client mis à jour.');
    }

    public function delete($id)
    {
        abort(403, 'Accès refusé. Seul le gérant peut supprimer un client.');
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
