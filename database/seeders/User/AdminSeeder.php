<?php

namespace Database\Seeders;

use App\Models\UserAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin account
        UserAccount::firstOrCreate(
            ['username' => env('ADMIN_USERNAME', 'admin')],
            [
                'email' => env('ADMIN_EMAIL', 'admin@kbc.edu.ph'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin12345')),
                'role' => 'admin',
                'is_active' => true,
                'password_changed' => true,
            ]
        );
    }
}
