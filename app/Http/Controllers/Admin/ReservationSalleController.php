<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservationSalle;
use Illuminate\Http\Request;

class ReservationSalleController extends Controller
{
    public function index()
    {
        $data['header_title'] = 'Réservations des Salles';
        $data['reservations'] = ReservationSalle::select('reservation_salles.*', 'users.name as teacher_name', 'salles.nom as salle_name')
            ->leftJoin('users', 'users.id', '=', 'reservation_salles.teacher_id')
            ->leftJoin('salles', 'salles.id', '=', 'reservation_salles.salle_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.reservations.index', $data);
    }

    public function update(Request $request, $id)
    {
        $reservation = ReservationSalle::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:en_attente,approuve,refuse',
        ]);

        $reservation->statut = $request->statut;
        $reservation->save();

        return redirect()->back()->with('success', 'Statut de réservation mis à jour.');
    }

    public function delete($id)
    {
        $reservation = ReservationSalle::findOrFail($id);
        $reservation->delete();

        return redirect()->back()->with('success', 'Réservation supprimée.');
    }
}
