<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Leave::getLeaves();
        $data['header_title'] = 'Gestion des Congés';
        return view('admin.leaves.list', $data);
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave         = Leave::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();

        return redirect('admin/leaves/list')->with('success', 'Statut du congé mis à jour');
    }

    public function delete($id)
    {
        Leave::findOrFail($id)->delete();
        return redirect('admin/leaves/list')->with('success', 'Congé supprimé');
    }
}
