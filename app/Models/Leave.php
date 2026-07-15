<?php

namespace App\Models;

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

    public function calculateWorkingDays(Carbon $startDate, Carbon $endDate): int
    {
        $workingDays = 0;
        $date = $startDate->copy();

        while ($date->lte($endDate)) {
            if ($date->dayOfWeek !== Carbon::SUNDAY) {
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
