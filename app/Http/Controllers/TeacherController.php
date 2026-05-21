<?php

namespace App\Http\Controllers;

use App\Models\TeacherModel;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = TeacherModel::with('userAccount')->get();
        return view('Teacher.Teacher.Teacher', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('Teacher.Teacher.partials.form');
        }
        
        return view('Teacher.Teacher.addteacher');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'username' => trim((string) $request->input('username')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'contact' => preg_replace('/\D+/', '', (string) $request->input('contact')),
        ]);

        $request->validate([
            'fname'     => 'required|string|max:255',
            'mname'     => 'nullable|string|max:255',
            'lname'     => 'required|string|max:255',
            'username'  => ['required', 'string', 'max:255', Rule::unique('user_accounts', 'username')],
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('teachers', 'email'),
                Rule::unique('user_accounts', 'email'),
            ],
            'password'  => 'required|string|min:8|confirmed',
            'contact'   => ['required', 'digits:11', Rule::unique('teachers', 'contact')],
            'specialization' => 'nullable|string|max:255',
        ]);
        
        // Create UserAccount first
        $userAccount = UserAccount::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        // Create Teacher with user_account_id
        $teacher = TeacherModel::create(array_merge(
            $request->only('fname', 'mname', 'lname', 'email', 'contact', 'specialization'),
            ['user_account_id' => $userAccount->id]
        ));

        Log::info('Teacher added successfully with UserAccount ID: ' . $userAccount->id);
        
        if (request()->ajax()) {
            return response()->json([
                'message' => 'Teacher added successfully.',
                'redirect' => route('Teacher.index'),
            ]);
        }

        return redirect()->route('Teacher.show', $teacher->id)->with('success', 'Teacher added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = TeacherModel::with('userAccount')->findOrFail($id);
        
        if (request()->ajax()) {
            return view('Teacher.Teacher.partials.view', compact('teacher'));
        }
        
        return view('Teacher.Teacher.viewteacher', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = TeacherModel::findOrFail($id);
        
        if (request()->ajax()) {
            return view('Teacher.Teacher.partials.form', compact('teacher'));
        }
        
        return view('Teacher.Teacher.editteacher', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'username' => trim((string) $request->input('username')),
            'email' => strtolower(trim((string) $request->input('email'))),
            'contact' => preg_replace('/\D+/', '', (string) $request->input('contact')),
        ]);

        $teacher = TeacherModel::findOrFail($id);

        $rules = [
            'fname'     => 'required|string|max:255',
            'mname'     => 'nullable|string|max:255',
            'lname'     => 'required|string|max:255',
            'username'  => ['required', 'string', 'max:255', Rule::unique('user_accounts', 'username')->ignore($teacher->user_account_id)],
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('teachers', 'email')->ignore($id),
                Rule::unique('user_accounts', 'email')->ignore($teacher->user_account_id),
            ],
            'contact'   => ['required', 'digits:11', Rule::unique('teachers', 'contact')->ignore($id)],
            'specialization' => 'nullable|string|max:255',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $teacher->update($request->only(
            'fname',
            'mname',
            'lname', 
            'email', 
            'contact',
            'specialization'
        ));

        if ($teacher->userAccount) {
            $teacher->userAccount->update([
                'email' => $request->input('email'),
                'username' => $request->input('username'),
            ]);
        }

        if ($request->filled('password') && $teacher->userAccount) {
            $teacher->userAccount->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        Log::info('Teacher updated successfully.');

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Teacher updated successfully.',
                'redirect' => route('Teacher.index'),
            ]);
        }

        return redirect()->route('Teacher.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = TeacherModel::findOrFail($id);
        $teacher->delete();

        Log::info('Teacher deleted successfully.');

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Teacher deleted successfully.',
                'redirect' => route('Teacher.index'),
            ]);
        }

        return redirect()->route('Teacher.index')->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Show the change password form
     */
    public function changePasswordForm(string $id)
    {
        $teacher = TeacherModel::with('userAccount')->findOrFail($id);
        return view('Teacher.Teacher.changepassword', compact('teacher'));
    }

    /**
     * Update the password
     */
    public function changePassword(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $teacher = TeacherModel::findOrFail($id);

        if (!$teacher->userAccount) {
            return redirect()->route('Teacher.index')->with('error', 'Teacher has no user account.');
        }

        $teacher->userAccount->update([
            'password' => Hash::make($request->input('password')),
        ]);

        Log::info('Teacher password updated successfully.');

        return redirect()->route('Teacher.index')->with('success', 'Password updated successfully.');
    }

    /**
     * Show the teacher dashboard
     */
    public function dashboard()
    {
        $teacher = TeacherModel::with('userAccount', 'courses')->firstOrFail();
        return view('Teacher.Teacher.dashboard', compact('teacher'));
    }
}
