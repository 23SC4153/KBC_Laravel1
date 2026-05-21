@extends('Student.Student.MainLayout')

@section('title')
    <h1>Course Details</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
            <div>
                <h2 class="mb-1">Course Profile Overview</h2>
                <p class="mb-0">Official information and description for this course.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge">ID {{ $degree->id }}</span>
                <span class="badge-dark">{{ $degree->DegreeCode }}</span>
            </div>
        </div>

        <hr>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">Course Name</label>
                    <div class="fw-semibold">{{ $degree->DegreeName }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
                    <label class="form-label mb-1">Course Code</label>
                    <div class="fw-semibold">{{ $degree->DegreeCode }}</div>
                </div>
            </div>

            <div class="col-12">
                <div class="border rounded-3 p-3" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">Description</label>
                    <div class="fw-semibold">{{ $degree->Description ?: '-' }}</div>
                </div>
            </div>
        </div>

        <hr>

        <div class="subjects-section">
            <h3 class="mb-3">Subjects in this Course</h3>
            @if($degree->subjects->count() > 0)
                <div class="row g-3">
                    @foreach($degree->subjects as $subject)
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded-3 p-3 h-100" style="background: var(--bg-secondary); border-color: var(--border-color) !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge">{{ $subject->SubjectCode }}</span>
                                    <small class="text-muted">{{ $subject->created_at->format('M Y') }}</small>
                                </div>
                                <h6 class="fw-semibold mb-2">{{ $subject->SubjectName }}</h6>
                                <p class="small text-muted mb-0">{{ $subject->Description ?: 'No description' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4" style="background: var(--bg-secondary); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                    <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No subjects assigned to this course yet.</p>
                </div>
            @endif
        </div>

        <hr>

        <div class="d-flex flex-wrap gap-2 justify-content-start">
            <a href="{{ route('Degree.edit', $degree->id) }}" class="btn btn-primary">Edit Course</a>
            <a href="{{ route('Degree.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
