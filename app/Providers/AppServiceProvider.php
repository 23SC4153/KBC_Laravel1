<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
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

        // Keep this for Railway deployment to ensure admin exists
        if (!app()->runningInConsole() && Schema::hasTable('user_accounts')) {
            \App\Models\UserAccount::firstOrCreate(
                ['username' => 'admin'],
                [
                    'email' => 'admin@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                    'role' => 'admin',
                    'is_active' => 1,
                    'password_changed' => 1,
                ]
            );
            
            \Illuminate\Support\Facades\Artisan::call('db:seed');
        }
    }


}
