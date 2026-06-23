<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\ReservationSalle;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationSalleController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Reservations de salles';
        $data['reservations'] = ReservationSalle::where('teacher_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('secretaire.reservations.index', $data);
    }

    public function create()
    {
        $data['header_title'] = 'Nouvelle reservation';
        $data['salles'] = Salle::where('is_delete', 0)->where('status', 0)->orderBy('name')->get();

        return view('secretaire.reservations.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'salle_name' => 'required|string',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'motif' => 'nullable|string|max:255',
        ]);

        $salle = Salle::firstOrCreate(['name' => $request->salle_name], [
            'capacity' => 30, // Default capacity
            'status' => 0,
            'is_delete' => 0,
            'created_by' => Auth::id(),
        ]);

        if (ReservationSalle::hasConflict(
            $salle->id,
            $request->date,
            $request->heure_debut,
            $request->heure_fin
        )) {
            return redirect()->back()->withInput()->with('error', 'Conflit de reservation : cette salle est deja reservee sur ce creneau.');
        }

        ReservationSalle::create([
            'salle_id' => $salle->id,
            'teacher_id' => Auth::id(),
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'motif' => $request->motif,
            'statut' => 'en_attente',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.reservations.index')->with('success', 'Reservation enregistree avec succes.');
    }

    public function delete($id)
    {
        $reservation = ReservationSalle::where('teacher_id', Auth::id())->findOrFail($id);
        $reservation->delete();

        return redirect()->route('teacher.reservations.index')->with('success', 'Reservation supprimee avec succes.');
    }
}
