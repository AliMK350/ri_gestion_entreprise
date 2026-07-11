<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Employe\LeaveController as EmployeLeaveController;
use App\Mail\LeaveDecisionMail;
use App\Mail\LeaveRequestedMail;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LeaveMailNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_leave_request_notifies_admins_and_decision_notifies_employee(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'email' => 'alimejber055@gmail.com',
            'password' => 'password',
            'user_type' => 1,
            'is_delete' => 0,
        ]);

        $employeeUser = User::factory()->create([
            'email' => 'employee-test@example.com',
            'password' => 'password',
            'user_type' => 2,
            'is_delete' => 0,
        ]);

        Employee::create([
            'user_id' => $employeeUser->id,
            'name' => 'Test Employee',
            'email' => 'employee-profile@example.com',
            'phone' => '0123456789',
            'position' => 'Developer',
            'department' => 'IT',
            'hired_at' => '2024-01-01',
            'status' => 0,
            'leave_balance_days' => 20,
        ]);

        $this->actingAs($employeeUser);

        $request = new Request([
            'start_date' => '2026-07-20',
            'end_date' => '2026-07-24',
            'type' => 'vacation',
            'reason' => 'Holiday',
        ]);

        $employeeController = new EmployeLeaveController();
        $employeeController->store($request);

        Mail::assertSent(LeaveRequestedMail::class, function ($mail) use ($admin) {
            return $mail->hasTo($admin->email);
        });

        $leave = Leave::latest()->first();

        $adminController = new AdminLeaveController();
        $adminController->updateStatus($leave->id, new Request(['status' => 'approved']));

        Mail::assertSent(LeaveDecisionMail::class, function ($mail) use ($employeeUser) {
            return $mail->hasTo($employeeUser->email) || $mail->hasTo('alimejber055@gmail.com');
        });
    }
}
