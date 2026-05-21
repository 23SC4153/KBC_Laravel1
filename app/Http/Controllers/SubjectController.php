<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\DegreeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects for a specific degree.
     */
    public function index()
    {
        $subjects = Subject::with('degree')->get();
        return view('Subject.Subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        $degrees = DegreeModel::all();
        
        if (request()->ajax()) {
            return view('Subject.Subject.partials.form', compact('degrees'));
        }
        
        return view('Subject.Subject.create', compact('degrees'));
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'SubjectName' => 'required|string|max:255',
            'SubjectCode' => 'required|string|unique:subjects,SubjectCode',
            'Description' => 'nullable|string',
            'degree_id' => 'required|exists:degree_models,id',
        ]);

        try {
            Subject::create([
                'SubjectName' => $request->SubjectName,
                'SubjectCode' => $request->SubjectCode,
                'Description' => $request->Description,
                'degree_id' => $request->degree_id,
            ]);

            Log::info('Subject created: ' . $request->SubjectCode);

            if ($request->ajax()) {
                return response()->json(['message' => 'Subject created successfully.'], 201);
            }

            return redirect()->route('Subject.index')->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating subject: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Failed to create subject.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create subject: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified subject.
     */
    public function show($id)
    {
        $subject = Subject::with('degree')->findOrFail($id);
        
        if (request()->ajax()) {
            return view('Subject.Subject.partials.view', compact('subject'));
        }
        
        return view('Subject.Subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $degrees = DegreeModel::all();
        
        if (request()->ajax()) {
            return view('Subject.Subject.partials.form', compact('subject', 'degrees'));
        }
        
        return view('Subject.Subject.edit', compact('subject', 'degrees'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'SubjectName' => 'required|string|max:255',
            'SubjectCode' => 'required|string|unique:subjects,SubjectCode,' . $id,
            'Description' => 'nullable|string',
            'degree_id' => 'required|exists:degree_models,id',
        ]);

        try {
            $subject->SubjectName = $request->SubjectName;
            $subject->SubjectCode = $request->SubjectCode;
            $subject->Description = $request->Description;
            $subject->degree_id = $request->degree_id;
            $subject->save();

            Log::info('Subject updated: ' . $subject->SubjectCode);

            if ($request->ajax()) {
                return response()->json(['message' => 'Subject updated successfully.']);
            }

            return redirect()->route('Subject.index')->with('success', 'Subject updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating subject: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Failed to update subject.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update subject: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subjectCode = $subject->SubjectCode;
            $subject->delete();

            Log::info('Subject deleted: ' . $subjectCode);

            if (request()->ajax()) {
                return response()->json(['message' => 'Subject deleted successfully.']);
            }

            return redirect()->route('Subject.index')->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting subject: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Failed to delete subject.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete subject: ' . $e->getMessage());
        }
    }

    /**
     * Display subjects for a specific degree.
     */
    public function byDegree($degreeId)
    {
        $degree = DegreeModel::findOrFail($degreeId);
        $subjects = Subject::where('degree_id', $degreeId)->get();
        return view('Subject.Subject.index', compact('degree', 'subjects'));
    }
}
