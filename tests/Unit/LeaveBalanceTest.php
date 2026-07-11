<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Tests\TestCase;

class LeaveBalanceTest extends TestCase
{
    public function test_working_days_exclude_sundays(): void
    {
        $leave = new Leave();
        $start = Carbon::parse('2026-07-06');
        $end = Carbon::parse('2026-07-12');

        $this->assertSame(6, $leave->calculateWorkingDays($start, $end));
    }

    public function test_employee_balance_can_be_checked_against_requested_days(): void
    {
        $employee = new Employee(['leave_balance_days' => 3]);
        $leave = new Leave();

        $this->assertTrue($leave->hasSufficientBalance($employee, Carbon::parse('2026-07-06'), Carbon::parse('2026-07-08')));
        $this->assertFalse($leave->hasSufficientBalance($employee, Carbon::parse('2026-07-06'), Carbon::parse('2026-07-10')));
    }
}
