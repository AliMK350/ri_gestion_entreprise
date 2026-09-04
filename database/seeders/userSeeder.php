<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Intern;
use App\Models\User;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Entreprise', 'email' => 'admin@example.com', 'password' => 'password', 'user_type' => 1],
            ['name' => 'Jane Secrétaire', 'email' => 'secretaire@example.com', 'password' => 'password', 'user_type' => 2],
            ['name' => 'Joshua Employé', 'email' => 'employe@example.com', 'password' => 'password', 'user_type' => 3],
            ['name' => 'Michael Gérant', 'email' => 'gerant@example.com', 'password' => 'password', 'user_type' => 4],
            ['name' => 'Ali  Mejber', 'email' => 'alimejber25@gmail.com', 'password' => 'password', 'user_type' => 3],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

        $admin      = User::where('email', 'admin@example.com')->first();
        $employe    = User::where('email', 'employe@example.com')->first();
        $secretaire = User::where('email', 'secretaire@example.com')->first();
        $gerant     = User::where('email', 'gerant@example.com')->first();

        $employeesData = [
            [
                'email'      => 'employe@example.com',
                'user_id'    => $employe->id,
                'name'       => 'Joshua Employé',
                'phone'      => '0600000001',
                'position'   => 'Technicien',
                'department' => 'Production',
                'hired_at'   => '2024-01-15',
                'status'     => 0,
            ],
            [
                'email'      => 'secretaire@example.com',
                'user_id'    => $secretaire->id,
                'name'       => 'Jane Secrétaire',
                'phone'      => '0600000010',
                'position'   => 'Secrétaire',
                'department' => 'Administration',
                'hired_at'   => '2024-03-01',
                'status'     => 0,
            ],
            [
                'email'      => 'gerant@example.com',
                'user_id'    => $gerant->id,
                'name'       => 'Michael Gérant',
                'phone'      => '0600000020',
                'position'   => 'Gérant',
                'department' => 'Direction',
                'hired_at'   => '2023-01-01',
                'status'     => 0,
            ],
            [
                'email'      => 'marie@entreprise.com',
                'user_id'    => null,
                'name'       => 'Marie Dupont',
                'phone'      => '0600000002',
                'position'   => 'Comptable',
                'department' => 'Finance',
                'hired_at'   => '2023-06-01',
                'status'     => 0,
            ]
        ];

        foreach ($employeesData as $empData) {
            $employee = Employee::updateOrCreate(['email' => $empData['email']], $empData);
            $employee->leave_balance_days = $employee->calculateAccruedBalanceFromHiredAt();
            $employee->save();
        }

        Intern::updateOrCreate(
            ['email' => 'stagiaire@entreprise.com'],
            [
                'name'       => 'Lucas Martin',
                'phone'      => '0600000003',
                'department' => 'Informatique',
                'started_at' => '2026-01-01',
                'ended_at'   => '2026-06-30',
            ]
        );

        Client::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'name'         => 'Pierre Client',
                'company_name' => 'Client SARL',
                'phone'        => '0100000000',
                'address'      => '12 rue de Paris',
                'status'       => 0,
                'created_by'   => $admin->id,
            ]
        );
    }
}
