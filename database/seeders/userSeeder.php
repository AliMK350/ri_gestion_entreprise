<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Default password for all accounts: password
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin UPF',
                'email' => 'admin@example.com',
                'password' => 'password',
                'user_type' => 1,
            ],
            [
                'name' => 'Jane Secrétaire',
                'email' => 'secretaire@example.com',
                'password' => 'password',
                'user_type' => 2,
            ],
            [
                'name' => 'Joshua Employé',
                'email' => 'employe@example.com',
                'password' => 'password',
                'user_type' => 3,
            ],
            [
                'name' => 'Michael Gérant',
                'email' => 'gerant@example.com',
                'password' => 'password',
                'user_type' => 4,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
