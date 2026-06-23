<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Mes notes';
        $data['user'] = Auth::user();
        $data['notes'] = Note::where('student_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('employe.notes.index', $data);
    }
}

