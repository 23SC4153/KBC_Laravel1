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

        // Seed the database
        if (!app()->runningInConsole()) {
            \Illuminate\Support\Facades\Artisan::call('db:seed');
        }
    }


}
