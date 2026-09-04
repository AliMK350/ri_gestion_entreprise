<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Tests\TestCase;

class LeaveBalanceTest extends TestCase
{
    public function test_working_days_exclude_weekends(): void
    {
        $leave = new Leave();
        $start = Carbon::parse('2026-07-06'); // Lundi
        $end = Carbon::parse('2026-07-12');   // Dimanche

        $this->assertSame(5, $leave->calculateWorkingDays($start, $end));
    }

    public function test_employee_balance_can_be_checked_against_requested_days(): void
    {
        $employee = new Employee(['leave_balance_days' => 3]);
        $leave = new Leave();

        $this->assertTrue($leave->hasSufficientBalance($employee, Carbon::parse('2026-07-06'), Carbon::parse('2026-07-08')));
        $this->assertFalse($leave->hasSufficientBalance($employee, Carbon::parse('2026-07-06'), Carbon::parse('2026-07-10')));
    }

    public function test_employee_seniority_and_leave_permissions(): void
    {
        // Employé récent (< 6 mois)
        $newEmployee = new Employee([
            'hired_at' => Carbon::now()->subMonths(2),
            'leave_balance_days' => 18.00,
        ]);

        $this->assertFalse($newEmployee->hasMinimumSeniority(6));
        $this->assertFalse($newEmployee->canRequestLeaveType('vacation')); // congé normal refusé
        $this->assertTrue($newEmployee->canRequestLeaveType('death'));     // cas spécial autorisé
        $this->assertTrue($newEmployee->canRequestLeaveType('marriage'));  // cas spécial autorisé
        $this->assertTrue($newEmployee->canRequestLeaveType('sick'));      // cas spécial autorisé
        $this->assertTrue($newEmployee->canRequestLeaveType('other', true)); // cas avec justification

        // Employé ancien (>= 6 mois)
        $seniorEmployee = new Employee([
            'hired_at' => Carbon::now()->subMonths(8),
            'leave_balance_days' => 18.00,
        ]);

        $this->assertTrue($seniorEmployee->hasMinimumSeniority(6));
        $this->assertTrue($seniorEmployee->canRequestLeaveType('vacation')); // autorisé
    }

    public function test_2_year_balance_reset(): void
    {
        $hiredAt = Carbon::now()->subMonths(24);
        $employee = new Employee([
            'name' => 'Test Reset',
            'email' => 'test_reset_' . uniqid() . '@example.com',
            'hired_at' => $hiredAt,
            'leave_balance_days' => 15.50,
        ]);

        $this->assertTrue($employee->checkAndReset2YearBalance());
        $this->assertEquals(0.00, $employee->leave_balance_days);
    }
}
