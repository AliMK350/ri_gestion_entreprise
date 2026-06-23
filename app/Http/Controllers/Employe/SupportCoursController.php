<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\SupportCours;
use Illuminate\Support\Facades\Auth;

class SupportCoursController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Supports de cours';
        $data['user'] = Auth::user();
        $data['supports'] = SupportCours::where('status', 0)
            ->orderBy('id', 'desc')
            ->get();

        return view('employe.supports.index', $data);
    }
}

