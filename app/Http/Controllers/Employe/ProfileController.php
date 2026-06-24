<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $data['getRecord']    = Employee::forUser(Auth::id());
        $data['header_title'] = 'Mon Profil';
        return view('employe.profile.show', $data);
    }
}
