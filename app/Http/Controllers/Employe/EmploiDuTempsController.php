<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Emploi du temps';
        $data['user'] = Auth::user();
        $data['seances'] = EmploiDuTemps::where(function ($query) {
            $query->where('student_id', Auth::id())
                ->orWhereNull('student_id');
        })->orderBy('id', 'desc')->get();

        return view('employe.emploi-du-temps.index', $data);
    }

    /**
     * Export the emploi du temps as a PDF.
     */
    public function pdf()
    {
        $data['header_title'] = 'Emploi du temps (PDF)';
        $data['user'] = Auth::user();
        $data['seances'] = EmploiDuTemps::where(function ($query) {
            $query->where('student_id', Auth::id())
                  ->orWhereNull('student_id');
        })->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadview('employe.emploi-du-temps.pdf', $data);
        return $pdf->download('emploi_du_temps.pdf');
    }
}

