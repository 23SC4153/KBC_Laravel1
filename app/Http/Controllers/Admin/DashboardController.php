<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use App\Models\UserAccount;
use App\Models\DegreeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        $totalStudents = StudentModel::query()->count();
        $totalTeachers = TeacherModel::query()->count();
        $totalDegrees = DegreeModel::query()->count();
        $totalUsers = UserAccount::query()->count();
        $activeUsers = UserAccount::where('is_active', '=', true)->count();

        return view('format.Admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalDegrees',
            'totalUsers',
            'activeUsers'
        ));
    }

    /**
     * Show user management
     */
    public function users()
    {
        $users = UserAccount::with(['student' => function ($query) {
            $query->select('id', 'user_account_id', 'fname', 'lname');
        }, 'teacher' => function ($query) {
            $query->select('id', 'user_account_id', 'fname', 'lname');
        }])->get();

        return view('format.Admin.users', compact('users'));
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus(string $id)
    {
        $user = UserAccount::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        Log::info('User status toggled for user: ' . $user->username);

        return redirect()->route('admin.users')->with('success', 'User status updated successfully.');
    }

    /**
     * Show statistics and reports
     */
    public function reports()
    {
        $studentsByDegree = StudentModel::with('degree')
            ->get()
            ->groupBy('degree.DegreeCode');
        
        $teacherCount = TeacherModel::query()->count();
        $studentCount = StudentModel::query()->count();
        $degreeCount = DegreeModel::query()->count();

        return view('format.Admin.reports', compact(
            'studentsByDegree',
            'teacherCount',
            'studentCount',
            'degreeCount'
        ));
    }

    /**
     * Show system settings
     */
    public function settings()
    {
        return view('format.Admin.settings');
    }
}
