<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Request;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'position', 'specialite', 'city', 'cv_path', 'hired_at', 'status', 'leave_balance_days', 'last_leave_reset_at',
    ];

    protected $casts = [
        'hired_at'             => 'date',
        'last_leave_reset_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    public function getSeniorityDate(): ?Carbon
    {
        return $this->hired_at ? Carbon::parse($this->hired_at) : null;
    }

    public function getSeniorityInMonths(?Carbon $onDate = null): int
    {
        if (!$this->hired_at) {
            return 0;
        }

        $startDate = Carbon::parse($this->hired_at);
        $date = $onDate ? $onDate->copy() : Carbon::now();

        if ($startDate->greaterThan($date)) {
            return 0;
        }

        return (int) $startDate->diffInMonths($date);
    }

    public function getSeniorityFormattedAttribute(): string
    {
        if (!$this->hired_at) {
            return "Date d'embauche non renseignée";
        }

        $startDate = Carbon::parse($this->hired_at);
        $now = Carbon::now();

        if ($startDate->greaterThan($now)) {
            return "Embauche à venir";
        }

        $years = (int) $startDate->diffInYears($now);
        $months = (int) $startDate->copy()->addYears($years)->diffInMonths($now);

        if ($years > 0) {
            $yearText = $years === 1 ? '1 an' : $years . ' ans';
            if ($months > 0) {
                return $yearText . ' et ' . $months . ' mois';
            }
            return $yearText;
        }

        if ($months > 0) {
            return $months . ' mois';
        }

        $days = (int) $startDate->diffInDays($now);
        if ($days > 0) {
            return $days . ' jour' . ($days > 1 ? 's' : '');
        }

        return "Moins d'un jour";
    }

    public function calculateAccruedBalanceFromHiredAt(?Carbon $onDate = null): float
    {
        if (!$this->hired_at) {
            return 0.00;
        }

        $totalMonths = $this->getSeniorityInMonths($onDate);
        $cycleMonths = $totalMonths % 24; // Réinitialisation après 2 ans (24 mois)

        return round($cycleMonths * 1.5, 2);
    }

    public function hasMinimumSeniority(int $months = 6): bool
    {
        return $this->getSeniorityInMonths() >= $months;
    }

    public function canRequestLeaveType(string $type, bool $hasJustificationFile = false, ?string $reason = null): bool
    {
        if ($this->hasMinimumSeniority(6)) {
            return true;
        }

        // Cas spéciaux toujours autorisés pour < 6 mois
        if (in_array($type, ['death', 'marriage', 'sick'], true)) {
            return true;
        }

        // Pour les autres types (non-vacation), un cas très spécial avec justification
        if ($type !== 'vacation' && ($hasJustificationFile || (!empty($reason) && strlen(trim($reason)) >= 10))) {
            return true;
        }

        return false;
    }

    public function checkAndReset2YearBalance(?Carbon $onDate = null): bool
    {
        if (!$this->hired_at) {
            return false;
        }

        $date = $onDate ? $onDate->copy() : Carbon::now();
        $totalMonths = $this->getSeniorityInMonths($date);

        // Réinitialisation après chaque 2 ans (tous les 24 mois)
        if ($totalMonths >= 24 && ($totalMonths % 24 === 0)) {
            $lastReset = $this->last_leave_reset_at ? Carbon::parse($this->last_leave_reset_at) : null;
            if (!$lastReset || $lastReset->format('Y-m') !== $date->format('Y-m')) {
                $this->leave_balance_days = 0.00;
                $this->last_leave_reset_at = $date->toDateString();
                $this->save();
                return true;
            }
        }

        return false;
    }

    static public function getEmployees()
    {
        $return = self::query();

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }

        return $return->orderBy('id', 'desc')->paginate(10);
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function forUser($userId)
    {
        return self::where('user_id', $userId)->first();
    }
}

