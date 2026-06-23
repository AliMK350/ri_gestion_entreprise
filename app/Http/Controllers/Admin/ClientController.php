<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function list()
    {
        $data['getRecord'] = Client::getClients();
        $data['header_title'] = 'Liste des Clients';
        return view('admin.clients.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Ajouter un Nouveau Client';
        return view('admin.clients.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required',
        ]);

        $client = new Client;
        $client->name = trim($request->name);
        $client->email = trim($request->email);
        $client->company_name = trim($request->company_name);
        $client->phone = trim($request->phone);
        $client->address = trim($request->address);
        $client->status = intval($request->status);
        $client->created_by = Auth::user()->id;
        $client->save();

        return redirect('admin/clients/list')->with('success', 'Client créé avec succès');
    }

    public function edit($id)
    {
        $data['getRecord'] = Client::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Modifier le Client';
            return view('admin.clients.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required',
        ]);

        $client = Client::getSingle($id);
        if (empty($client)) {
            abort(404);
        }

        $client->name = trim($request->name);
        $client->email = trim($request->email);
        $client->company_name = trim($request->company_name);
        $client->phone = trim($request->phone);
        $client->address = trim($request->address);
        $client->status = intval($request->status);
        $client->save();

        return redirect('admin/clients/list')->with('success', 'Client mis à jour avec succès');
    }

    public function delete($id)
    {
        $client = Client::getSingle($id);
        if (empty($client)) {
            abort(404);
        }
        $client->is_delete = 1;
        $client->save();

        return redirect('admin/clients/list')->with('success', 'Client supprimé avec succès');
    }
}
