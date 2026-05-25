<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\Subject;

class EnrollmentController extends Controller
{
    /**
     * Show the enrollment page where admin can select a student and enroll subjects.
     */
    public function index()
    {
        $students = StudentModel::orderBy('lname')->get();
        $subjects = Subject::orderBy('SubjectCode')->get();
        // Build a mapping of student_id => [subject_ids]
        $mapping = [];
        foreach ($students as $s) {
            $mapping[$s->id] = $s->subjects()->pluck('subjects.id')->toArray();
        }

        return view('Enrollment.index', compact('students', 'subjects', 'mapping'));
    }

    /**
     * Handle AJAX enrollment update.
     */
    public function enroll(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'exists:student_modelss,id'],
            'subjects' => ['nullable', 'array'],
            'subjects.*' => ['exists:subjects,id'],
        ]);

        $student = StudentModel::findOrFail($request->input('student_id'));
        $student->subjects()->sync($request->input('subjects', []));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Enrollment updated successfully.']);
        }

        return redirect()->back()->with('success', 'Enrollment updated successfully.');
    }
}
