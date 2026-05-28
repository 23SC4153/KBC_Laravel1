<?php

namespace App\Providers;

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // replace schema to https when production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Ensure Railway has an admin account, without running full seeders on every request.
        if (!app()->runningInConsole() && Schema::hasTable('user_accounts')) {
            UserAccount::firstOrCreate(
                ['username' => 'admin'],
                [
                    'email' => 'admin@example.com',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'is_active' => 1,
                    'password_changed' => 1,
                ]
            );
        }
    }


}
