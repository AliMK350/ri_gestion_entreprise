<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\SubjectModel;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportCoursController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Supports de cours';
        $data['supports'] = SupportCours::where('created_by', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.supports.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Ajouter un support';
        $data['subjects'] = SubjectModel::where('is_delete', 0)->orderBy('name')->get();

        return view('secretaire.supports.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file',
        ]);

        $filePath = null;
        if ($request->hasFile('fichier')) {
            $filePath = $request->file('fichier')->store('supports', 'public');
        }

        SupportCours::create([
            'subject_name' => $request->subject_name,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.supports.index')->with('success', 'Support ajoute avec succes.');
    }
}
