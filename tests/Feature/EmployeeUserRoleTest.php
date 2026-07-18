<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\EmployeeController;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EmployeeUserRoleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('user_type')->default(3);
            $table->tinyInteger('is_delete')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        $this->app['db']->connection()->getSchemaBuilder()->create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('cv_path')->nullable();
            $table->date('hired_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function test_admin_can_assign_role_when_creating_a_user_for_employee(): void
    {
        if (!extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('PDO SQLite extension is not available in this environment.');
        }

        $request = new Request([
            'name' => 'Ali',
            'email' => 'employee@example.com',
            'phone' => '0600000000',
            'position' => 'Développeur',
            'department' => 'IT',
            'status' => '0',
            'new_user_name' => 'Slimane',
            'new_user_email' => 'slimane@example.com',
            'new_user_password' => 'Password123',
            'new_user_role' => '2',
        ]);

        $controller = new EmployeeController();
        $response = $controller->insert($request);

        $user = User::where('email', 'slimane@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame(2, $user->user_type);
        $this->assertTrue($response->isRedirect());
    }
}
