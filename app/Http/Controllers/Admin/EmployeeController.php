<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvtechPerson;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function list(Request $request)
    {
        $query = Employee::with('user');
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        });
        $query->when($request->filled('city'), fn ($query) => $query->where('city', 'like', '%' . trim($request->city) . '%'));
        $query->when($request->filled('position'), fn ($query) => $query->where('position', 'like', '%' . trim($request->position) . '%'));
        $query->when($request->filled('specialite'), fn ($query) => $query->where('specialite', 'like', '%' . trim($request->specialite) . '%'));
        $query->when($request->filled('status'), fn ($query) => $query->where('status', $request->status));
        $query->when($request->filled('account'), fn ($query) => $request->account === 'yes' ? $query->whereNotNull('user_id') : $query->whereNull('user_id'));
        $query->when($request->filled('cv'), fn ($query) => $request->cv === 'yes' ? $query->whereNotNull('cv_path') : $query->whereNull('cv_path'));
        $query->when($request->filled('hired_from'), fn ($query) => $query->whereDate('hired_at', '>=', $request->hired_from));
        $query->when($request->filled('hired_to'), fn ($query) => $query->whereDate('hired_at', '<=', $request->hired_to));
        $data['getRecord']    = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $data['header_title'] = 'Liste des Employés';
        return view('admin.employees.list', $data);
    }

    public function add()
    {
        $data['users']        = User::where('user_type', '!=', 1)->where('is_delete', 0)->orderBy('name')->get();
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
            'specialite'        => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
            'cv_file'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'hired_at'          => 'nullable|date',
            'user_id'           => 'nullable|exists:users,id',
            'new_user_name'     => 'nullable|string|max:255',
            'new_user_email'    => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
            'new_user_password' => 'nullable|string|min:7',
            'new_user_role'     => 'nullable|in:2,3,4',
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
                'new_user_role'     => 'required_with_all:new_user_name,new_user_email,new_user_password|in:2,3,4',
            ]);

            $user = new User;
            $user->name = trim($request->new_user_name);
            $user->email = trim($request->new_user_email);
            $user->password = Hash::make($request->new_user_password);
            $user->must_change_password = true;
            $user->user_type = intval($request->new_user_role ?? 3);
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
        $employee->specialite = trim($request->specialite);
        $employee->city       = trim($request->city);
        $employee->cv_path    = $cvPath;
        $employee->hired_at   = $request->hired_at;
        $employee->user_id    = $userId;
        $employee->leave_balance_days = $employee->calculateAccruedBalanceFromHiredAt();
        $employee->save();
        CvtechPerson::syncEmployee($employee);

        return redirect('admin/employees/list')->with('success', 'Employé créé avec succès');
    }

    public function edit($id)
    {
        $data['getRecord'] = Employee::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['users']        = User::where('user_type', '!=', 1)->where('is_delete', 0)->orderBy('name')->get();
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
            'specialite'        => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
            'cv_file'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'hired_at'          => 'nullable|date',
            'user_id'           => 'nullable|exists:users,id',
            'new_user_name'     => 'nullable|string|max:255',
            'new_user_email'    => 'required_with_all:new_user_name,new_user_password|email|unique:users,email',
            'new_user_password' => 'nullable|string|min:7',
            'new_user_role'     => 'nullable|in:2,3,4',
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
            $user->must_change_password = true;
            $user->user_type = intval($request->new_user_role ?? 3);
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
        $employee->specialite = trim($request->specialite);
        $employee->city       = trim($request->city);
        $employee->hired_at   = $request->hired_at;
        $employee->user_id    = $userId;
        $employee->save();
        CvtechPerson::syncEmployee($employee);

        return redirect('admin/employees/list')->with('success', 'Employé mis à jour avec succès');
    }

    public function delete($id)
    {
        if (auth()->user()->user_type == 4) {
            return redirect('admin/employees/list')->with('error', 'Action non autorisée : Le Gérant ne peut pas supprimer un employé.');
        }

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
