<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Intern;
use Illuminate\Support\Facades\Auth;

class PersonnelController extends Controller
{
    public function index()
    {
        $data['employees']    = Employee::where('status', 0)->orderBy('name')->get();
        $data['interns']      = Intern::orderBy('name')->get();
        $data['myProfile']    = Employee::forUser(Auth::id());
        $data['header_title'] = 'Annuaire du Personnel';
        return view('employe.personnel.index', $data);
    }
}
