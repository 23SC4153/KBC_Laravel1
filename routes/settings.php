<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('login.session')->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', function () {})->name('user-password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance.edit');
    
    // Two factor dummy routes
    Route::get('settings/two-factor', function () {})->name('two-factor.show');
    Route::post('settings/two-factor', function () {})->name('two-factor.enable');
    Route::delete('settings/two-factor', function () {})->name('two-factor.disable');
    Route::post('settings/two-factor/qr-code', function () {})->name('two-factor.qrCode');
    Route::post('settings/two-factor/recovery-codes', function () {})->name('two-factor.recoveryCodes');
    Route::post('settings/two-factor/secret-key', function () {})->name('two-factor.secretKey');
    Route::post('settings/two-factor/recovery-codes/regenerate', function () {})->name('two-factor.regenerateRecoveryCodes');
    Route::post('settings/two-factor/confirm', function () {})->name('two-factor.confirm');

    // Verification
    Route::post('email/verification-notification', function () {})->name('verification.send');
});

