<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function list()
    {
        $data['getRecord']    = Employee::getEmployees();
        $data['header_title'] = 'Liste des Employés';
        return view('admin.employees.list', $data);
    }

    public function add()
    {
        $data['users']        = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Ajouter un Employé';
        return view('admin.employees.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:employees',
            'phone'      => 'nullable|string|max:50',
            'position'   => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'hired_at'   => 'nullable|date',
            'status'     => 'required|in:0,1',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $employee             = new Employee;
        $employee->name       = trim($request->name);
        $employee->email      = trim($request->email);
        $employee->phone      = trim($request->phone);
        $employee->position   = trim($request->position);
        $employee->department = trim($request->department);
        $employee->hired_at   = $request->hired_at;
        $employee->status     = intval($request->status);
        $employee->user_id    = $request->user_id ?: null;
        $employee->save();

        return redirect('admin/employees/list')->with('success', 'Employé créé avec succès');
    }

    public function edit($id)
    {
        $data['getRecord'] = Employee::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['users']        = User::where('user_type', 3)->where('is_delete', 0)->orderBy('name')->get();
        $data['header_title'] = 'Modifier l\'Employé';
        return view('admin.employees.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email,' . $id,
            'phone'      => 'nullable|string|max:50',
            'position'   => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'hired_at'   => 'nullable|date',
            'status'     => 'required|in:0,1',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $employee = Employee::getSingle($id);
        if (empty($employee)) {
            abort(404);
        }

        $employee->name       = trim($request->name);
        $employee->email      = trim($request->email);
        $employee->phone      = trim($request->phone);
        $employee->position   = trim($request->position);
        $employee->department = trim($request->department);
        $employee->hired_at   = $request->hired_at;
        $employee->status     = intval($request->status);
        $employee->user_id    = $request->user_id ?: null;
        $employee->save();

        return redirect('admin/employees/list')->with('success', 'Employé mis à jour avec succès');
    }

    public function delete($id)
    {
        $employee = Employee::getSingle($id);
        if (empty($employee)) {
            abort(404);
        }
        $employee->delete();

        return redirect('admin/employees/list')->with('success', 'Employé supprimé avec succès');
    }

    public function show($id)
    {
        $data['getRecord'] = Employee::with(['absences', 'leaves'])->findOrFail($id);
        $data['header_title'] = 'Fiche Employé';
        return view('admin.employees.show', $data);
    }
}
