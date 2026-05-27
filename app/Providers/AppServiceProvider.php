<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Schema\defaultStringLength;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Seeder account
        if (Schema::hasTable('user_accounts') && \App\Models\UserAccount::count() === 0) {
            \App\Models\UserAccount::create([
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'password_changed' => true,
            ]);
        }
    }


}
