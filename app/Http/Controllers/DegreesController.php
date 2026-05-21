<?php

namespace App\Http\Controllers;

use App\Models\DegreeModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DegreesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degrees = DegreeModel::orderBy('DegreeName')->get();
        return view('Degree.Degrees.Degrees', compact('degrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('Degree.Degrees.partials.form');
        }
        
        return view('Degree.Degrees.addDegree');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'DegreeName' => ['required', 'string', 'max:255', 'unique:degree_models,DegreeName'],
            'DegreeCode' => ['required', 'string', 'max:50', 'unique:degree_models,DegreeCode'],
            'Description' => 'nullable|string|max:1000',
        ]);

        DegreeModel::create($request->only('DegreeName', 'DegreeCode', 'Description'));

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Course added successfully.',
                'redirect' => route('Degree.index'),
            ]);
        }

        return redirect()->route('Degree.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $degree = DegreeModel::with('subjects')->findOrFail($id);
        
        if (request()->ajax()) {
            return view('Degree.Degrees.partials.view', compact('degree'));
        }
        
        return view('Degree.Degrees.viewDegree', compact('degree'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $degree = DegreeModel::findOrFail($id);
        
        if (request()->ajax()) {
            return view('Degree.Degrees.partials.form', compact('degree'));
        }
        
        return view('Degree.Degrees.editDegree', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $degree = DegreeModel::findOrFail($id);

        $request->validate([
        'DegreeName' => ['required','string','max:255',
                Rule::unique('degree_models', 'DegreeName')->ignore($degree->id),
            ],
            'DegreeCode' => ['required','string','max:50',
                Rule::unique('degree_models', 'DegreeCode')->ignore($degree->id),
            ],
            
            'Description' => 'nullable|string|max:1000',
        ]);

        $degree->update($request->only(
            'DegreeName',
            'DegreeCode',
            'Description'
        ));

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Course updated successfully.',
                'redirect' => route('Degree.index'),
            ]);
        }

        return redirect()->route('Degree.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DegreeModel::findOrFail($id)->delete();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Course deleted successfully.',
                'redirect' => route('Degree.index'),
            ]);
        }

        return redirect()->route('Degree.index')->with('success', 'Course deleted successfully.');
    }
}
