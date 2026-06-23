<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Mes absences';
        $data['user'] = Auth::user();
        $data['absences'] = Absence::where('student_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
        $data['total_absences'] = $data['absences']->count();

        return view('employe.absences.index', $data);
    }
}

