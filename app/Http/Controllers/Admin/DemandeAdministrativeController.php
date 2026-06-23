<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeAdministrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DemandeAdministrativeController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Demandes Administratives';
        $data['demandes'] = DemandeAdministrative::select('demande_administratives.*', 'users.name as user_name', 'users.user_type')
            ->leftJoin('users', function($join) {
                $join->on('users.id', '=', 'demande_administratives.student_id')
                     ->orOn('users.id', '=', 'demande_administratives.teacher_id');
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.demandes.index', $data);
    }

    public function update(Request $request, $id)
    {
        $demande = DemandeAdministrative::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:en_attente,approuvee,rejetee',
            'response' => 'nullable|string',
            'response_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $demande->statut = $request->statut;
        $demande->response = $request->response;
        $demande->processed_by = Auth::id();

        if (!empty($request->file('response_file'))) {
            $ext = $request->file('response_file')->getClientOriginalExtension();
            $file = $request->file('response_file');
            $randomStr = date('Ymdhis').Str::random(10);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/demandes/', $filename);
            $demande->response_file = $filename;
        }

        $demande->save();

        return redirect()->back()->with('success', 'Demande mise à jour avec succès.');
    }
}
