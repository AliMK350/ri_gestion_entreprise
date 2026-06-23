<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use Illuminate\Support\Facades\Auth;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Emploi du temps';
        $data['seances'] = EmploiDuTemps::where('teacher_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.emploi-du-temps.index', $data);
    }
}
