<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\ClassModel;
use App\Models\EmploiDuTemps;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $date = date('Y-m-d');

        $data = [
            'header_title' => 'Mon Espace Étudiant',
            'userType' => $user->user_type,
            'total_absences' => \App\Models\Absence::where('student_id', $user->id)->count(),
            'total_notes' => \App\Models\Note::where('student_id', $user->id)->count(),
            'total_demandes' => \App\Models\DemandeAdministrative::where('student_id', $user->id)->count(),
            'announcements' => Annonce::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'upcoming_sessions' => EmploiDuTemps::where('class_id', $user->class_id)
                ->whereDate('date_seance', '>=', $date)
                ->orderBy('date_seance')
                ->take(5)
                ->get(),
        ];

        return view('employe.dashboard', $data);
    }
}
