<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvtechPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvtechController extends Controller
{
    public function list(Request $request)
    {
        $sort = in_array($request->get('sort'), ['name', 'created_at', 'hired_at'], true) ? $request->get('sort') : 'name';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $people = CvtechPerson::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('specialite', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('person_type'), fn ($query) => $query->where('person_type', $request->person_type))
            ->when($request->filled('city'), fn ($query) => $query->where('city', 'like', '%' . $request->city . '%'))
            ->when($request->filled('specialite'), fn ($query) => $query->where('specialite', 'like', '%' . trim($request->specialite) . '%'))
            ->when($request->filled('position'), fn ($query) => $query->where('position', 'like', '%' . trim($request->position) . '%'))
            ->when($request->filled('niveau_etude'), fn ($query) => $query->where('niveau_etude', $request->niveau_etude))
            ->when($request->filled('source'), fn ($query) => $request->source === 'manual' ? $query->whereNull('source_type') : $query->where('source_type', $request->source))
            ->when($request->filled('cv'), fn ($query) => $request->cv === 'yes' ? $query->whereNotNull('cv_path') : $query->whereNull('cv_path'))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate($request->person_type === 'intern' ? 'started_at' : 'hired_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate($request->person_type === 'intern' ? 'ended_at' : 'hired_at', '<=', $request->date_to))
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $niveauEtudes = CvtechPerson::whereNotNull('niveau_etude')->where('niveau_etude', '!=', '')->distinct()->orderBy('niveau_etude')->pluck('niveau_etude');

        return view('admin.cvtech.list', [
            'people'      => $people,
            'header_title' => 'CVTech',
            'niveauEtudes' => $niveauEtudes,
        ]);
    }

    public function add()
    {
        return view('admin.cvtech.add', ['header_title' => 'Ajouter à la CVTech']);
    }

    public function insert(Request $request)
    {
        $data = $request->validate([
            'person_type'  => 'required|in:employee,intern,manual',
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'city'         => 'nullable|string|max:255',
            'specialite'   => 'nullable|string|max:255',
            'position'     => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:50',
            'started_at'   => 'nullable|date',
            'ended_at'     => 'nullable|date|after_or_equal:started_at',
            'hired_at'     => 'nullable|date',
            'notes'        => 'nullable|string|max:5000',
        ]);

        $data['source_type'] = null;
        $data['source_id'] = null;
        CvtechPerson::create($data);

        return redirect('admin/cvtech/list')->with('success', 'Personne ajoutée à la CVTech avec succès.');
    }

    public function delete($id)
    {
        $person = CvtechPerson::findOrFail($id);
        $person->delete();

        return redirect('admin/cvtech/list')->with('success', 'Personne retirée de la CVTech.');
    }

    public function uploadCv($id, Request $request)
    {
        $person = CvtechPerson::findOrFail($id);
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($person->cv_path && Storage::disk('public')->exists($person->cv_path)) {
            Storage::disk('public')->delete($person->cv_path);
        }

        $person->cv_path = $request->file('cv_file')->store('cvs', 'public');
        $person->save();

        return redirect()->back()->with('success', 'CV ajouté avec succès.');
    }

    public function viewCv($id)
    {
        $person = CvtechPerson::findOrFail($id);

        if (!$person->cv_path || !Storage::disk('public')->exists($person->cv_path)) {
            return redirect()->back()->with('error', 'Aucun CV disponible pour cette personne.');
        }

        return response()->file(Storage::disk('public')->path($person->cv_path));
    }
}
