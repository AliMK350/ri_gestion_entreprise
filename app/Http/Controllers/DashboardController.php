<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\ClassModel;
use App\Models\EmploiDuTemps;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();
        $date = date('Y-m-d');

        $data = [
            'header_title' => 'Tableau de bord',
            'userType' => $user->user_type,
            'total_students' => User::where('user_type', 3)->where('is_delete', 0)->count(), // Employés
            'total_teachers' => User::where('user_type', 2)->where('is_delete', 0)->count(), // Secrétaires
            'total_parents' => User::where('user_type', 4)->where('is_delete', 0)->count(),  // Gérants
            'total_classes' => ClassModel::where('is_delete', 0)->count(),
            'total_subjects' => SubjectModel::where('is_delete', 0)->count(),
            'total_clients' => Client::where('is_delete', 0)->count(),
            'announcements' => Annonce::where('status', 0)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'upcoming_sessions' => EmploiDuTemps::whereDate('date_seance', '>=', $date)->count(),
            'user_schedule' => collect(),
        ];

        if ($user->user_type == 2) {
            $data['user_schedule'] = EmploiDuTemps::where('teacher_id', $user->id)
                ->whereDate('date_seance', '>=', $date)
                ->orderBy('date_seance')
                ->take(5)
                ->get();
        } elseif ($user->user_type == 3) {
            $data['user_schedule'] = EmploiDuTemps::where('student_id', $user->id)
                ->whereDate('date_seance', '>=', $date)
                ->orderBy('date_seance')
                ->take(5)
                ->get();
        }

        if ($user->user_type == 1) {
            return view('admin.dashboard', $data);
        } elseif ($user->user_type == 2) {
            return view('secretaire.dashboard', $data);
        } elseif ($user->user_type == 3) {
            return view('employe.dashboard', $data);
        } elseif ($user->user_type == 4) {
            return view('gerant.dashboard', $data);
        }

        return redirect('/');
    }
}
