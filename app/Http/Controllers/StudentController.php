<?php

namespace App\Http\Controllers;


use App\Models\DegreeModel;
use App\Models\StudentModel;
use App\Models\Subject;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Show the form for enrolling a student in multiple subjects.
     */
    public function enrollSubjectsForm($id)
    {
        $student = StudentModel::with(['degree', 'subjects'])->findOrFail($id);
        // Show all subjects so student can enroll in any available subject
        $subjects = Subject::orderBy('SubjectCode', 'asc')->get();
        return view('Student.Student.enrollsubjects', compact('student', 'subjects'));
    }

    /**
     * Handle enrollment of a student in multiple subjects.
     */
    public function enrollSubjects(Request $request, $id)
    {
        $student = StudentModel::findOrFail($id);
        $request->validate([
            'subjects' => ['array'],
            'subjects.*' => ['exists:subjects,id'],
        ]);
        $student->subjects()->sync($request->subjects ?? []);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Subjects updated!']);
        }

        return redirect()->route('Student.show', $student->id)->with('success', 'Subjects updated!');
    }
// Only keep one class definition below
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Students = StudentModel::with('degree', 'userAccount')->get();
        return view('Student.Student.Student', compact('Students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees = DegreeModel::orderBy('DegreeCode', 'asc')->get();
        
        if (request()->ajax()) {
            return view('Student.Student.partials.form', compact('degrees'));
        }
        
        return view('Student.Student.addstudent', compact('degrees'));
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
                Rule::unique('student_modelss', 'email'),
                Rule::unique('user_accounts', 'email'),
            ],
            'password'  => 'required|string|min:8|confirmed',
            'contact'   => ['required', 'digits:11', Rule::unique('student_modelss', 'contact')],
            'degree_id' => 'required|exists:degree_models,id',
        ]);
        
        // Create UserAccount first
        $userAccount = UserAccount::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'student',
            'is_active' => true,
        ]);

        // Create Student with user_account_id
        $student = StudentModel::create(array_merge(
            $request->only('fname', 'mname', 'lname', 'email', 'contact', 'degree_id'),
            ['user_account_id' => $userAccount->id]
        ));

        Log::info('Student added successfully with UserAccount ID: ' . $userAccount->id);
        
        if (app('request')->ajax()) {
            return response()->json([
                'message' => 'Student added successfully.',
                'redirect' => route('Student.index'),
            ]);
        }

        return redirect()->route('Student.show', $student->id)->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = StudentModel::with(['degree', 'userAccount', 'subjects.degree'])->findOrFail($id);
        $availableSubjects = Subject::query()
            ->where('degree_id', '=', $student->degree_id)
            ->orderBy('SubjectCode', 'asc')
            ->get()
            ->reject(function ($subject) use ($student) {
                return $student->subjects->contains('id', $subject->id);
            });
        
        if (app('request')->ajax()) {
            return view('Student.Student.partials.view', compact('student', 'availableSubjects'));
        }
        
        return view('Student.Student.viewstudent', compact('student', 'availableSubjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = StudentModel::findOrFail($id);
        $degrees = DegreeModel::orderBy('DegreeCode', 'asc')->get();
        
        if (app('request')->ajax()) {
            return view('Student.Student.partials.form', compact('student', 'degrees'));
        }
        
        return view('Student.Student.editstudent', compact('student', 'degrees'));
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

        $student = StudentModel::findOrFail($id);

        $rules = [
            'fname'     => 'required|string|max:255',
            'mname'     => 'nullable|string|max:255',
            'lname'     => 'required|string|max:255',
            'username'  => ['required', 'string', 'max:255', Rule::unique('user_accounts', 'username')->ignore($student->user_account_id)],
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('student_modelss', 'email')->ignore($id),
                Rule::unique('user_accounts', 'email')->ignore($student->user_account_id),
            ],
            'contact'   => ['required', 'digits:11', Rule::unique('student_modelss', 'contact')->ignore($id)],
        ];

        if (session('role') === 'admin') {
            $rules['degree_id'] = 'required|exists:degree_models,id';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $studentData = $request->only(
            'fname',
            'mname',
            'lname', 
            'email', 
            'contact'
        );

        if (session('role') === 'admin' && $request->filled('degree_id')) {
            $studentData['degree_id'] = $request->degree_id;
        }

        $student->update($studentData);

        if ($student->userAccount) {
            $student->userAccount->update([
                'email' => $request->input('email'),
                'username' => $request->input('username'),
            ]);
        }

        if ($request->filled('password') && $student->userAccount) {
            $student->userAccount->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        Log::info('Student updated successfully.');

        if (app('request')->ajax()) {
            return response()->json([
                'message' => 'Student updated successfully.',
                'redirect' => route('Student.index'),
            ]);
        }

        return redirect()->route('Student.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = StudentModel::findOrFail($id);
        $student->delete();

        Log::info('Student deleted successfully.');

        if (app('request')->ajax()) {
            return response()->json([
                'message' => 'Student deleted successfully.',
                'redirect' => route('Student.index'),
            ]);
        }

        return redirect()->route('Student.index')->with('success', 'Student deleted successfully.');
    }

    /**
     * Show the change password form
     */
    public function changePasswordForm(string $id)
    {
        $student = StudentModel::with('userAccount')->findOrFail($id);
        return view('Student.Student.changepassword', compact('student'));
    }

    /**
     * Update the password
     */
    public function changePassword(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $student = StudentModel::findOrFail($id);

        if (!$student->userAccount) {
            return redirect()->route('Student.index')->with('error', 'Student has no user account.');
        }

        $student->userAccount->update([
            'password' => Hash::make($request->input('password')),
        ]);

        Log::info('Student password updated successfully.');
        return redirect()->route('Student.show', $student->id)->with('success', 'Password changed successfully.');
    }

    /**
     * Enroll the student in a subject.
     */
    public function enrollSubject(Request $request, string $id)
    {
        $student = StudentModel::findOrFail($id);

        $request->validate([
            'subject_id' => [
                'required',
                'integer',
                Rule::exists('subjects', 'id')->where(function ($query) use ($student) {
                    $query->where('degree_id', $student->degree_id);
                }),
            ],
        ]);

        $student->subjects()->syncWithoutDetaching([$request->subject_id]);

        return redirect()->route('Student.show', $student->id)->with('success', 'Subject enrolled successfully.');
    }

    /**
     * Remove a subject enrollment from the student.
     */
    public function unenrollSubject(string $id, string $subjectId)
    {
        $student = StudentModel::findOrFail($id);
        $student->subjects()->detach($subjectId);

        return redirect()->route('Student.show', $student->id)->with('success', 'Subject removed successfully.');
    }
}
