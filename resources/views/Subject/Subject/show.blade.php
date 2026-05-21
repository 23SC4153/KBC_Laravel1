@extends('Student.Student.MainLayout')

@section('title')
    <h1>Subject Details</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
            <div>
                <h2 class="mb-1">Subject Profile Overview</h2>
                <p class="mb-0">Official information and description for this subject.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge">ID {{ $subject->id }}</span>
                <span class="badge-dark">{{ $subject->SubjectCode }}</span>
            </div>
        </div>

        <hr>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: var(--bg-card-alt); border-color: var(--border-gold) !important;">
                    <label class="form-label mb-1">Subject Name</label>
                    <div class="fw-semibold">{{ $subject->SubjectName }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: var(--bg-card-alt); border-color: var(--border-gold) !important;">
                    <label class="form-label mb-1">Subject Code</label>
                    <div class="fw-semibold">{{ $subject->SubjectCode }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: var(--bg-card-alt); border-color: var(--border-gold) !important;">
                    <label class="form-label mb-1">Degree Program</label>
                    <div class="fw-semibold">{{ $subject->degree->DegreeName ?? 'N/A' }} ({{ $subject->degree->DegreeCode ?? 'N/A' }})</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: var(--bg-card-alt); border-color: var(--border-gold) !important;">
                    <label class="form-label mb-1">Created Date</label>
                    <div class="fw-semibold">{{ $subject->created_at->format('M d, Y') }}</div>
                </div>
            </div>

            <div class="col-12">
                <div class="border rounded-3 p-3" style="background: var(--bg-card-alt); border-color: var(--border-gold) !important;">
                    <label class="form-label mb-1">Description</label>
                    <div class="fw-semibold">{{ $subject->Description ?: 'No description provided' }}</div>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex flex-wrap gap-2 justify-content-start">
            <a href="{{ route('Subject.edit', $subject->id) }}" class="btn btn-primary">Edit Subject</a>
            <a href="{{ route('Subject.index') }}" class="btn btn-secondary">Back to Subjects</a>
            <form action="{{ route('Subject.destroy', $subject->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subject? This action cannot be undone.')">
                    Delete Subject
                </button>
            </form>
        </div>
    </div>
@endsection
