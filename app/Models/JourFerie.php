<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JourFerie extends Model
{
    protected $table = 'jours_feries';

    protected $fillable = ['nom', 'date', 'type'];

    protected $casts = [
        'date' => 'date',
    ];

    // ─── Scopes & Méthodes statiques ────────────────────────────────────────

    /**
     * Liste paginée pour l'interface admin.
     * Supporte un filtre optionnel par type et/ou par année.
     */
    public static function getHolidays()
    {
        $query = self::orderBy('date', 'asc');

        if (!empty(request('type'))) {
            $query->where('type', request('type'));
        }

        if (!empty(request('year'))) {
            $query->whereYear('date', request('year'));
        }

        return $query->paginate(20);
    }

    /**
     * Retourne un tableau de chaînes 'Y-m-d' représentant toutes les dates
     * fériées comprises dans l'intervalle [$startDate, $endDate].
     * Utilisé par Leave::calculateWorkingDays() pour exclure les fériés.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array<string>  ex. ['2026-01-01', '2026-05-01']
     */
    public static function getHolidayDatesForRange(Carbon $startDate, Carbon $endDate): array
    {
        return self::whereBetween('date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();
    }

    // ─── Accesseurs ─────────────────────────────────────────────────────────

    /**
     * Libellé humain du type de jour férié.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'fixe'      => 'Fixe',
            'religieux' => 'Religieux',
            default     => ucfirst($this->type),
        };
    }

    /**
     * Shortcut pour récupérer un seul enregistrement (cohérence avec l'existant).
     */
    public static function getSingle(int $id): ?self
    {
        return self::find($id);
    }
}
