<?php

namespace App\Models;

use App\Models\JourFerie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Request;

class Leave extends Model
{
    protected $fillable = [
        'employee_id', 'start_date', 'end_date', 'type', 'status', 'reason', 'justification_file',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calcule le nombre de jours ouvrables entre deux dates.
     *
     * Sont exclus :
     *  - les samedis et dimanches (week-end non travaillé)
     *  - les jours fériés enregistrés dans la table jours_feries
     *
     * @param Carbon $startDate  Date de début (inclusive)
     * @param Carbon $endDate    Date de fin   (inclusive)
     * @return int               Nombre de jours ouvrables réels
     */
    public function calculateWorkingDays(Carbon $startDate, Carbon $endDate): int
    {
        // Récupère les dates fériées dans la plage en un seul appel BDD
        $holidays = JourFerie::getHolidayDatesForRange($startDate, $endDate);

        $workingDays = 0;
        $date = $startDate->copy();

        while ($date->lte($endDate)) {
            $isWeekend = in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
            $isHoliday = in_array($date->toDateString(), $holidays);

            if (!$isWeekend && !$isHoliday) {
                $workingDays++;
            }

            $date->addDay();
        }

        return $workingDays;
    }

    public function hasSufficientBalance(Employee $employee, Carbon $startDate, Carbon $endDate): bool
    {
        $requestedDays = $this->calculateWorkingDays($startDate, $endDate);
        $balance = max(0, (int) $employee->leave_balance_days);

        return $balance >= $requestedDays;
    }

    static public function getLeaves()
    {
        $return = self::with('employee');

        if (!empty(Request::get('status'))) {
            $return = $return->where('status', Request::get('status'));
        }

        return $return->orderBy('created_at', 'desc')->paginate(10);
    }
}
