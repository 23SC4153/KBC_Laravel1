<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->has('user_id')) {
            $role = session()->get('role');
            if ($role === 'student') {
                return redirect()->route('user.dashboard');
            } elseif ($role === 'teacher') {
                return redirect()->route('Teacher.dashboard');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('User.loginPage');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username or email is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $login = trim((string) $request->input('username'));
        $password = $request->input('password');

        $user = UserAccount::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username or email not found.')->withInput();
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'Password is incorrect.')->withInput();
        }

        if (!$user->is_active) {
            return redirect()->back()->with('error', 'Your account is not active. Please contact admin.')->withInput();
        }

        $request->session()->regenerate();

        $request->session()->put([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
        ]);
        
        // If password hasn't been changed yet, redirect to change password form
        if (!$user->password_changed) {
            if ($user->role === 'student') {
                return redirect()->route('user.changePasswordForm')->with('success', 'Login successful! Please update your password.');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('user.changePasswordForm')->with('success', 'Login successful! Please update your password.');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful! Please update your password.');
            }
        }
        
        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('Teacher.dashboard')->with('success', 'Login successful!');
        } else {
            // student
            return redirect()->route('user.dashboard')->with('success', 'Login successful!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show the dashboard for logged-in user based on role
     */
    public function dashboard(Request $request)
    {
        $user = $this->resolveSessionUser($request);
        if (!$user) {
            return redirect()->route('login.index')->with('error', 'Please login first.');
        }

        $role = (string) $request->session()->get('role');

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'teacher') {
            return redirect()->route('Teacher.dashboard');
        } elseif ($role === 'student') {
            $user->load('student');
            if (!$user->student) {
                return redirect()->route('login.index')->with('error', 'Student account not found.');
            }

            $sessionUsername = $request->session()->get('username', $user->username);
            $welcomeMessage = 'Welcome, Student ' . $sessionUsername . '!';

            return view('Student.Student.dashboard', compact('user', 'welcomeMessage'));
        }

        return redirect()->route('login.index')->with('error', 'Unauthorized access.');
    }

    /**
     * Show the change password form for logged-in user
     */
    public function changePasswordForm(Request $request)
    {
        $user = $this->resolveSessionUser($request);
        if (!$user) {
            return redirect()->route('login.index')->with('error', 'Please login first.');
        }

        $role = (string) $request->session()->get('role');

        if ($role === 'student') {
            $user->load('student');
            return view('Student.Student.changeMyPassword', compact('user'));
        } elseif ($role === 'teacher') {
            $user->load('teacher');
            return view('Teacher.Teacher.changeMyPassword', compact('user'));
        }

        return redirect()->route('login.index')->with('error', 'Unauthorized access.');
    }

    /**
     * Update the password for logged-in user
     */
    public function changePassword(Request $request)
    {
        $user = $this->resolveSessionUser($request);
        if (!$user) {
            return redirect()->route('login.index')->with('error', 'Please login first.');
        }

        $role = (string) $request->session()->get('role');

        if ($role !== 'student' && $role !== 'teacher') {
            return redirect()->route('login.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check((string) $request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->input('password')),
            'password_changed' => true,
        ]);

        if ($role === 'teacher') {
            return redirect()->route('Teacher.dashboard')->with('success', 'Password changed successfully.');
        }

        return redirect()->route('user.dashboard')->with('success', 'Password changed successfully.');
    }

    /**
     * Logout the current user
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('success', 'Logged out successfully.');
    }

    private function resolveSessionUser(Request $request): ?UserAccount
    {
        $userId = $request->session()->get('user_id');
        if (!$userId) {
            return null;
        }

        $user = UserAccount::find($userId);
        if (!$user instanceof UserAccount) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return null;
        }

        // Keep session identity in sync in case old sessions miss role/username.
        $request->session()->put([
            'username' => $user->username,
            'role' => $user->role,
        ]);

        return $user;
    }


}

