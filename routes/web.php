<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DegreesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::redirect('/', '/login');

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::middleware(['login.session'])->group(function() {
    
    // Dashboard & Account Management
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/change-password', [LoginController::class, 'changePasswordForm'])->name('user.changePasswordForm');
    Route::put('/change-password', [LoginController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');

    // Student Management - Full CRUD
    Route::resource('/Student', StudentController::class);
    Route::get('/Student/{id}/enroll-subjects', [StudentController::class, 'enrollSubjectsForm'])->name('Student.enrollSubjectsForm');
    Route::post('/Student/{id}/enroll-subjects', [StudentController::class, 'enrollSubjects'])->name('Student.enrollSubjects');
    // Enrollment admin page
    Route::get('/Enrollment', [App\Http\Controllers\EnrollmentController::class, 'index'])->name('Enrollment.index');
    Route::post('/Enrollment/enroll', [App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('Enrollment.enroll');
    Route::get('/Student/{id}/changePassword', [StudentController::class, 'changePasswordForm'])->name('Student.changePasswordForm');
    Route::put('/Student/{id}/changePassword', [StudentController::class, 'changePassword'])->name('Student.changePassword');
    Route::post('/Student/{id}/subjects', [StudentController::class, 'enrollSubject'])->name('Student.enrollSubject');
    Route::delete('/Student/{id}/subjects/{subjectId}', [StudentController::class, 'unenrollSubject'])->name('Student.unenrollSubject');

    // Teacher Management - Full CRUD
    Route::resource('/Teacher', TeacherController::class);
    Route::get('/Teacher/{id}/changePassword', [TeacherController::class, 'changePasswordForm'])->name('Teacher.changePasswordForm');
    Route::put('/Teacher/{id}/changePassword', [TeacherController::class, 'changePassword'])->name('Teacher.changePassword');
    Route::get('/teacher-dashboard', [TeacherController::class, 'dashboard'])->name('Teacher.dashboard');

    // Degree Management (Courses)
    Route::resource('/Degree', DegreesController::class);

    // Subject Management
    Route::resource('/Subject', SubjectController::class);
    
    // Admin Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::post('/users/{id}/toggle', [AdminDashboardController::class, 'toggleUserStatus'])->name('toggleUserStatus');
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');

        // User Management CRUD
        Route::resource('/user', AdminUserController::class);
    });
});
