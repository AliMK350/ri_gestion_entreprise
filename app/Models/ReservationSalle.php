<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSalle extends Model
{
    use HasFactory;

    protected $table = 'reservation_salles';

    protected $fillable = [
        'salle_id',
        'teacher_id',
        'date',
        'heure_debut',
        'heure_fin',
        'motif',
        'statut',
        'created_by',
    ];

    public static function hasConflict($salleId, $date, $heureDebut, $heureFin, $excludeId = null)
    {
        $query = self::where('salle_id', $salleId)
            ->where('date', $date)
            ->where('statut', '!=', 'refuse')
            ->where(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                    ->where('heure_fin', '>', $heureDebut);
            });

        if (!empty($excludeId)) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
