<?php

namespace Database\Seeders;

use App\Models\UserAccount;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // UserAccount::factory(10)->create();

        // Create a fallback test user without relying on a model factory
        UserAccount::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'username' => 'testuser',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => 1,
            ]
        );

        // Create an admin user
        UserAccount::firstOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => 1,
            ]
        );

        // Sample domain data: degrees, subjects, teachers, students
        $this->call([
            SampleDataSeeder::class,
        ]);
    }
}
