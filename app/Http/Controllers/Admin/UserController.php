<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAccount;
use App\Models\StudentModel;
use App\Models\TeacherModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = UserAccount::with(['student', 'teacher'])->get();
        return view('format.Admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = ['admin', 'teacher', 'student'];

        if (request()->ajax()) {
            return view('format.Admin.users.partials.form', compact('roles'));
        }

        return view('format.Admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:user_accounts,username',
            'email' => 'required|email|unique:user_accounts,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
        ]);

        try {
            // Create user account
            $user = UserAccount::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->boolean('is_active', true),
                'password_changed' => false,
            ]);

            // Auto-create related record based on role
            if ($request->role === 'student') {
                try {
                    StudentModel::create([
                        'user_account_id' => $user->id,
                        'fname' => 'New',
                        'lname' => 'Student',
                        'email' => $user->email,
                        'contact' => 0,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Student record creation failed but user was created: ' . $e->getMessage());
                }
            } elseif ($request->role === 'teacher') {
                try {
                    TeacherModel::create([
                        'user_account_id' => $user->id,
                        'fname' => 'New',
                        'lname' => 'Teacher',
                        'email' => $user->email,
                        'contact' => 0,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Teacher record creation failed but user was created: ' . $e->getMessage());
                }
            }

            Log::info('New user created: ' . $user->username . ' with role: ' . $user->role);

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'User created successfully.',
                    'redirect' => route('admin.user.index'),
                ]);
            }

            return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = UserAccount::with(['student', 'teacher'])->findOrFail($id);

        if (request()->ajax()) {
            return view('format.Admin.users.partials.view', compact('user'));
        }

        return view('format.Admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = UserAccount::findOrFail($id);
        $roles = ['admin', 'teacher', 'student'];

        if (request()->ajax()) {
            return view('format.Admin.users.partials.form', compact('user', 'roles'));
        }

        return view('format.Admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = UserAccount::findOrFail($id);

        $request->validate([
            'username' => 'required|string|min:3|unique:user_accounts,username,' . $id,
            'email' => 'required|email|unique:user_accounts,email,' . $id,
            'role' => 'required|in:admin,teacher,student',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            // Update user
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->is_active = $request->boolean('is_active', true);

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Handle role change - auto-create if switching roles
            if ($request->role === 'student' && !$user->student) {
                try {
                    StudentModel::create([
                        'user_account_id' => $user->id,
                        'fname' => 'New',
                        'lname' => 'Student',
                        'email' => $user->email,
                        'contact' => 0,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Student record creation failed during update: ' . $e->getMessage());
                }
            } elseif ($request->role === 'teacher' && !$user->teacher) {
                try {
                    TeacherModel::create([
                        'user_account_id' => $user->id,
                        'fname' => 'New',
                        'lname' => 'Teacher',
                        'email' => $user->email,
                        'contact' => 0,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Teacher record creation failed during update: ' . $e->getMessage());
                }
            }

            Log::info('User updated: ' . $user->username);

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'User updated successfully.',
                    'redirect' => route('admin.user.index'),
                ]);
            }

            return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = UserAccount::findOrFail($id);

        try {
            $username = $user->username;
            $user->delete();
            Log::info('User deleted: ' . $username);

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'User deleted successfully.',
                    'redirect' => route('admin.user.index'),
                ]);
            }

            return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus($id)
    {
        $user = UserAccount::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        Log::info('User status toggled for user: ' . $user->username);
        return redirect()->route('admin.user.index')->with('success', 'User status updated successfully.');
    }
}
