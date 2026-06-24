<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Intern;

class PersonnelController extends Controller
{
    public function index()
    {
        $data['employees']    = Employee::orderBy('name')->get();
        $data['interns']      = Intern::orderBy('name')->get();
        $data['header_title'] = 'Consultation du Personnel';
        return view('admin.personnel.index', $data);
    }
}
