<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvtechPerson;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternController extends Controller
{
    public function list(Request $request)
    {
        $query = Intern::query();
        $query->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        });
        $query->when($request->filled('city'), fn ($query) => $query->where('city', 'like', '%' . trim($request->city) . '%'));
        $query->when($request->filled('specialite'), fn ($query) => $query->where('specialite', 'like', '%' . trim($request->specialite) . '%'));
        $query->when($request->filled('niveau_etude'), fn ($query) => $query->where('niveau_etude', $request->niveau_etude));
        $query->when($request->filled('cv'), fn ($query) => $request->cv === 'yes' ? $query->whereNotNull('cv_path') : $query->whereNull('cv_path'));
        $query->when($request->filled('started_from'), fn ($query) => $query->whereDate('started_at', '>=', $request->started_from));
        $query->when($request->filled('started_to'), fn ($query) => $query->whereDate('started_at', '<=', $request->started_to));
        $query->when($request->filled('ended_from'), fn ($query) => $query->whereDate('ended_at', '>=', $request->ended_from));
        $query->when($request->filled('ended_to'), fn ($query) => $query->whereDate('ended_at', '<=', $request->ended_to));
        $today = now()->toDateString();
        $query->when($request->filled('period'), function ($query) use ($request, $today) {
            if ($request->period === 'current') {
                $query->whereDate('started_at', '<=', $today)->where(function ($query) use ($today) { $query->whereNull('ended_at')->orWhereDate('ended_at', '>=', $today); });
            } elseif ($request->period === 'finished') {
                $query->whereNotNull('ended_at')->whereDate('ended_at', '<', $today);
            } elseif ($request->period === 'upcoming') {
                $query->whereDate('started_at', '>', $today);
            }
        });
        $data['niveauEtudes'] = Intern::whereNotNull('niveau_etude')->where('niveau_etude', '!=', '')->distinct()->orderBy('niveau_etude')->pluck('niveau_etude');
        $data['getRecord']    = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $data['header_title'] = 'Liste des Stagiaires';
        return view('admin.interns.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Ajouter un Stagiaire';
        return view('admin.interns.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:interns',
            'phone'        => 'nullable|string|max:50',
            'specialite'   => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:50',
            'cv_file'      => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'started_at'   => 'nullable|date',
            'ended_at'     => 'nullable|date|after_or_equal:started_at',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('cvs', 'public');
        }

        $intern               = new Intern;
        $intern->name         = trim($request->name);
        $intern->email        = trim($request->email);
        $intern->phone        = trim($request->phone);
        $intern->specialite   = trim($request->specialite);
        $intern->city         = trim($request->city);
        $intern->niveau_etude = $request->niveau_etude ? trim($request->niveau_etude) : null;
        $intern->cv_path      = $cvPath;
        $intern->started_at   = $request->started_at;
        $intern->ended_at     = $request->ended_at;
        $intern->save();
        CvtechPerson::syncIntern($intern);

        return redirect('admin/interns/list')->with('success', 'Stagiaire créé avec succès');
    }

    public function edit($id)
    {
        $data['getRecord'] = Intern::getSingle($id);
        if (empty($data['getRecord'])) {
            abort(404);
        }
        $data['header_title'] = 'Modifier le Stagiaire';
        return view('admin.interns.edit', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:interns,email,' . $id,
            'phone'        => 'nullable|string|max:50',
            'specialite'   => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:50',
            'cv_file'      => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'started_at'   => 'nullable|date',
            'ended_at'     => 'nullable|date|after_or_equal:started_at',
        ]);

        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }

        if ($request->hasFile('cv_file')) {
            if (!empty($intern->cv_path) && Storage::disk('public')->exists($intern->cv_path)) {
                Storage::disk('public')->delete($intern->cv_path);
            }
            $intern->cv_path = $request->file('cv_file')->store('cvs', 'public');
        }

        $intern->name         = trim($request->name);
        $intern->email        = trim($request->email);
        $intern->phone        = trim($request->phone);
        $intern->specialite   = trim($request->specialite);
        $intern->city         = trim($request->city);
        $intern->niveau_etude = $request->niveau_etude ? trim($request->niveau_etude) : null;
        $intern->started_at   = $request->started_at;
        $intern->ended_at     = $request->ended_at;
        $intern->save();
        CvtechPerson::syncIntern($intern);

        return redirect('admin/interns/list')->with('success', 'Stagiaire mis à jour avec succès');
    }

    public function delete($id)
    {
        if (auth()->user()->user_type == 4) {
            return redirect('admin/interns/list')->with('error', 'Action non autorisée : Le Gérant ne peut pas supprimer un stagiaire.');
        }

        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }
        $intern->delete();

        return redirect('admin/interns/list')->with('success', 'Stagiaire supprimé avec succès');
    }

    public function downloadCv($id)
    {
        $intern = Intern::getSingle($id);
        if (empty($intern)) {
            abort(404);
        }

        if (empty($intern->cv_path) || !Storage::disk('public')->exists($intern->cv_path)) {
            return redirect('admin/interns/list')->with('error', 'Aucun CV disponible pour ce stagiaire.');
        }

        $extension = pathinfo($intern->cv_path, PATHINFO_EXTENSION);
        $filename  = 'CV_' . str_replace(' ', '_', $intern->name) . '.' . $extension;

        return Storage::disk('public')->download($intern->cv_path, $filename);
    }
}
