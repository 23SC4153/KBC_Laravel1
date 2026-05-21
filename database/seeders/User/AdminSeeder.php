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
            ['username' => 'admin'],
            [
                'email' => 'admin@kbc.local',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'password_changed' => true,
            ]
        );
    }
}
