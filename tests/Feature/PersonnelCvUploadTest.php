<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Intern;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PersonnelCvUploadTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_employee_and_intern_can_upload_a_cv(): void
    {
        $this->post('/admin/employees/add', [
            'name' => 'Test Employee',
            'email' => 'employee-cv@example.com',
            'phone' => '0123456789',
            'position' => 'Developer',
            'department' => 'IT',
            'hired_at' => '2026-01-01',
            'status' => '0',
            'cv_file' => UploadedFile::fake()->createWithContent('cv.pdf', 'fake pdf content', 'application/pdf'),
        ])->assertRedirect('/admin/employees/list');

        $employee = Employee::latest()->first();
        $this->assertNotNull($employee);
        $this->assertNotEmpty($employee->cv_path);
        $this->assertTrue(Storage::disk('public')->exists($employee->cv_path));

        $this->post('/admin/interns/add', [
            'name' => 'Test Intern',
            'email' => 'intern-cv@example.com',
            'phone' => '0987654321',
            'department' => 'Marketing',
            'started_at' => '2026-02-01',
            'ended_at' => '2026-06-30',
            'cv_file' => UploadedFile::fake()->createWithContent('cv.docx', 'fake docx content', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
        ])->assertRedirect('/admin/interns/list');

        $intern = Intern::latest()->first();
        $this->assertNotNull($intern);
        $this->assertNotEmpty($intern->cv_path);
        $this->assertTrue(Storage::disk('public')->exists($intern->cv_path));
    }
}
