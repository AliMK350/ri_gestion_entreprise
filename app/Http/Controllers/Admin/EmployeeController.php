<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:employees',
            'phone'             => 'nullable|string|max:50',
            'position'          => 'nullable|string|max:255',
            'department'        => 'nullable|string|max:255',
            'cv_file'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'hired_at'          => 'nullable|date',
            'status'            => 'required|in:0,1',
            'user_id'           => 'nullable|exists:users,id',
            'new_user_name'     => 'nullable|string|max:255',
            'new_user_email' => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
            'new_user_password' => 'nullable|string|min:7',
        ]);

        if ($request->user_id && ($request->new_user_name || $request->new_user_email || $request->new_user_password)) {
            return redirect()->back()
                ->withErrors(['user_id' => 'Choisissez soit un compte existant, soit créez un nouveau compte, pas les deux.'])
                ->withInput();
        }

        if ($request->user_id) {
            $userId = $request->user_id;
        } elseif (!empty($request->new_user_name) || !empty($request->new_user_email) || !empty($request->new_user_password)) {
            $request->validate([
                'new_user_name'     => 'required_with_all:new_user_email,new_user_password|string|max:255',
                'new_user_email'    => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
                'new_user_password' => 'required_with_all:new_user_name,new_user_email|string|min:7',
            ]);

            $user = new User;
            $user->name = trim($request->new_user_name);
            $user->email = trim($request->new_user_email);
            $user->password = Hash::make($request->new_user_password);
            $user->user_type = 3;
            $user->save();

            $userId = $user->id;
        } else {
            $userId = null;
        }

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('cvs', 'public');
        }

        $employee             = new Employee;
        $employee->name       = trim($request->name);
        $employee->email      = trim($request->email);
        $employee->phone      = trim($request->phone);
        $employee->position   = trim($request->position);
        $employee->department = trim($request->department);
        $employee->cv_path    = $cvPath;
        $employee->hired_at   = $request->hired_at;
        $employee->status     = intval($request->status);
        $employee->user_id    = $userId;
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:employees,email,' . $id,
            'phone'             => 'nullable|string|max:50',
            'position'          => 'nullable|string|max:255',
            'department'        => 'nullable|string|max:255',
            'cv_file'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'hired_at'          => 'nullable|date',
            'status'            => 'required|in:0,1',
            'user_id'           => 'nullable|exists:users,id',
            'new_user_name'     => 'nullable|string|max:255',
            'new_user_email' => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
            'new_user_password' => 'nullable|string|min:7',
        ]);

        if ($request->user_id && ($request->new_user_name || $request->new_user_email || $request->new_user_password)) {
            return redirect()->back()
                ->withErrors(['user_id' => 'Choisissez soit un compte existant, soit créez un nouveau compte, pas les deux.'])
                ->withInput();
        }

        if ($request->user_id) {
            $userId = $request->user_id;
        } elseif (!empty($request->new_user_name) || !empty($request->new_user_email) || !empty($request->new_user_password)) {
            $request->validate([
                'new_user_name'     => 'required_with_all:new_user_email,new_user_password|string|max:255',
                'new_user_email'    => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
                'new_user_password' => 'required_with_all:new_user_name,new_user_email|string|min:7',
            ]);

            $user = new User;
            $user->name = trim($request->new_user_name);
            $user->email = trim($request->new_user_email);
            $user->password = Hash::make($request->new_user_password);
            $user->user_type = 3;
            $user->save();

            $userId = $user->id;
        } else {
            $userId = null;
        }

        $employee = Employee::getSingle($id);
        if (empty($employee)) {
            abort(404);
        }

        if ($request->hasFile('cv_file')) {
            if (!empty($employee->cv_path) && Storage::disk('public')->exists($employee->cv_path)) {
                Storage::disk('public')->delete($employee->cv_path);
            }
            $employee->cv_path = $request->file('cv_file')->store('cvs', 'public');
        }

        $employee->name       = trim($request->name);
        $employee->email      = trim($request->email);
        $employee->phone      = trim($request->phone);
        $employee->position   = trim($request->position);
        $employee->department = trim($request->department);
        $employee->hired_at   = $request->hired_at;
        $employee->status     = intval($request->status);
        $employee->user_id    = $userId;
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
