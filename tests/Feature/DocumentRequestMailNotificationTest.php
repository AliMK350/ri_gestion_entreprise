<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\DocumentRequestController as AdminDocumentRequestController;
use App\Http\Controllers\Employe\DocumentRequestController as EmployeDocumentRequestController;
use App\Mail\DocumentRequestCreatedMail;
use App\Mail\DocumentRequestDecisionMail;
use App\Models\DocumentRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DocumentRequestMailNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_document_request_notifies_admin_and_decision_notifies_employee(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'email' => 'director@company.test',
            'password' => Hash::make('password'),
            'user_type' => 1,
            'is_delete' => 0,
        ]);
        $employeeUser = User::factory()->create([
            'email' => 'employee@company.test',
            'password' => Hash::make('password'),
            'user_type' => 3,
            'is_delete' => 0,
        ]);
        $employee = Employee::create([
            'user_id' => $employeeUser->id,
            'name' => 'Test Employee',
            'email' => 'employee.profile@company.test',
            'phone' => '0600000000',
            'position' => 'Développeur',
            'specialite' => 'Informatique',
            'city' => 'Rabat',
            'hired_at' => '2024-01-01',
            'status' => 0,
            'leave_balance_days' => 20,
        ]);

        $this->actingAs($employeeUser);
        (new EmployeDocumentRequestController())->store(new Request([
            'document_type' => 'Attestation de travail',
            'reason' => 'Dossier administratif',
        ]));

        Mail::assertSent(DocumentRequestCreatedMail::class, fn ($mail) => $mail->hasTo($admin->email));

        $documentRequest = DocumentRequest::firstOrFail();
        (new AdminDocumentRequestController())->update($documentRequest->id, new Request([
            'status' => 'approved',
            'admin_response' => 'Votre document est prêt.',
        ]));

        Mail::assertSent(DocumentRequestDecisionMail::class, function ($mail) use ($employeeUser) {
            return $mail->hasTo($employeeUser->email)
                && $mail->status === 'approved';
        });
        $this->assertDatabaseHas('document_requests', [
            'id' => $documentRequest->id,
            'status' => 'approved',
            'admin_response' => 'Votre document est prêt.',
        ]);
    }
}
