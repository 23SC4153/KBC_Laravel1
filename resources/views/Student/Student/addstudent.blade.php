@extends('Student.Student.MainLayout')
@section('title')
    <h1>Add Student</h1>
@endsection
@section('subtitle')
    Create a new student account
@endsection
@section('content')
<div class="card" style="max-width: 600px; margin: 30px auto;">
    <h3 style="padding: 20px; border-bottom: 1px solid var(--border-gold); color: var(--tx-primary);">Add New Student</h3>
    <div style="padding: 20px;">
        <form action="{{ route('Student.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">First Name *</label>
                <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" required>
                @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname') }}">
                @error('mname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name *</label>
                <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}" required>
                @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Username *</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contact (11 digits) *</label>
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" placeholder="09xxxxxxxxx" required>
                @error('contact')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Degree *</label>
                <select name="degree_id" id="student-degree-select" data-student-degree-select class="form-control @error('degree_id') is-invalid @enderror" required>
                    <option value="">Select Degree</option>
                    @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>{{ $degree->DegreeCode }}</option>
                    @endforeach
                </select>
                @error('degree_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            @if(isset($subjects) && $subjects->count())
                @php
                    $selectedSubjectIds = old('subject_ids', []);
                    if (!is_array($selectedSubjectIds)) {
                        $selectedSubjectIds = [$selectedSubjectIds];
                    }
                @endphp
                <div class="mb-3">
                    <label class="form-label">Subjects (select multiple)</label>
                    <select name="subject_ids[]" id="student-subject-select" data-student-subject-select class="form-control @error('subject_ids') is-invalid @enderror @error('subject_ids.*') is-invalid @enderror" multiple size="8" data-empty-message="Select a degree first to load subjects.">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" data-degree-id="{{ $subject->degree_id }}" {{ in_array($subject->id, $selectedSubjectIds) ? 'selected' : '' }}>
                                {{ optional($subject->degree)->DegreeCode ?? 'No Degree' }} - {{ $subject->SubjectCode }} - {{ $subject->SubjectName }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted d-block mt-1">Hold Ctrl on Windows to select more than one subject.</small>
                    @error('subject_ids')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    @error('subject_ids.*')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Add Student</button>
                <a href="{{ route('Student.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
