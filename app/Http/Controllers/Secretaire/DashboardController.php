<?php

namespace App\Http\Controllers\Secretaire;

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
            'header_title' => 'Mon Espace Enseignant',
            'userType' => $user->user_type,
            'total_reservations' => \App\Models\ReservationSalle::where('teacher_id', $user->id)->count(),
            'total_demandes' => \App\Models\DemandeAdministrative::where('teacher_id', $user->id)->count(),
            'announcements' => Annonce::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'upcoming_sessions' => EmploiDuTemps::where('teacher_id', $user->id)
                ->whereDate('date_seance', '>=', $date)
                ->orderBy('date_seance')
                ->take(5)
                ->get(),
        ];

        return view('secretaire.dashboard', $data);
    }
}
