@extends('Student.Student.MainLayout')
@section('title')
    <h1>Student Details</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
            <div>
                <h2 class="mb-1">Student Profile Overview</h2>
                <p class="mb-0">Complete student information and enrollment details.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge" style="font-size: .82rem; padding: 7px 16px; letter-spacing: 1.1px;">ID {{ $student->id }}</span>
                <span class="badge-dark">{{ optional($student->degree)->DegreeCode ?? 'No Course' }}</span>
            </div>
        </div>

        <hr>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">First Name</label>
                    <div class="fw-semibold">{{ $student->fname }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">Middle Name</label>
                    <div class="fw-semibold">{{ $student->mname ?: '-' }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">Last Name</label>
                    <div class="fw-semibold">{{ $student->lname }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
                    <label class="form-label mb-1">Email Address</label>
                    <div class="fw-semibold">
                        <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
                    <label class="form-label mb-1">Contact Number</label>
                    <div class="fw-semibold">
                        <a href="tel:{{ $student->contact }}">{{ $student->contact }}</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="border rounded-3 p-3" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                    <label class="form-label mb-1">Course</label>
                    <div class="fw-semibold">
                        {{ optional($student->degree)->DegreeCode ?? '-' }}
                        @if(optional($student->degree)->Description)
                            - {{ optional($student->degree)->Description }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr class="mt-4">
                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Subject Enrollments</h5>
                    <span class="badge bg-secondary">{{ $student->subjects->count() }} enrolled</span>
                </div>

                @if($student->subjects->count())
                    <div class="row g-3 mb-3">
                        @foreach($student->subjects as $subject)
                            <div class="col-md-6 col-lg-4">
                                <div class="border rounded-3 p-3 h-100" style="background: rgba(13,110,253,0.03); border-color: rgba(13,110,253,0.14) !important;">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <div>
                                            <div class="fw-semibold">{{ $subject->SubjectCode }}</div>
                                            <div class="small text-muted">{{ $subject->SubjectName }}</div>
                                        </div>
                                        <form action="{{ route('Student.unenrollSubject', [$student->id, $subject->id]) }}" method="POST" onsubmit="return confirm('Remove this subject from the student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    </div>
                                    <div class="small text-muted">{{ $subject->Description ?: 'No description provided.' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mb-3">This student is not enrolled in any subjects yet.</div>
                @endif

                @if($availableSubjects->count())
                    <div class="border rounded-3 p-3" style="background: rgba(40,167,69,0.03); border-color: rgba(40,167,69,0.16) !important;">
                        <form action="{{ route('Student.enrollSubject', $student->id) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-8">
                                <label for="subject_id" class="form-label mb-1">Enroll in another subject</label>
                                <select name="subject_id" id="subject_id" class="form-select" required>
                                    <option value="">Choose a subject</option>
                                    @foreach($availableSubjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->SubjectCode }} - {{ $subject->SubjectName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Enroll Subject</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">No additional subjects are available for this degree.</div>
                @endif
            </div>

            @if($student->userAccount)
                <div class="col-12">
                    <hr class="mt-4">
                    <h5 class="mb-3">User Account Information</h5>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                        <label class="form-label mb-1">Username</label>
                        <div class="fw-semibold">{{ $student->userAccount->username }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                        <label class="form-label mb-1">Role</label>
                        <div class="fw-semibold">
                            <span class="badge bg-info">{{ ucfirst($student->userAccount->role) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                        <label class="form-label mb-1">Account Status</label>
                        <div class="fw-semibold">
                            @if($student->userAccount->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                        <label class="form-label mb-1">Account Created</label>
                        <div class="fw-semibold">{{ $student->userAccount->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            @endif
        </div>

        <hr>

        <div class="d-flex flex-wrap gap-2 justify-content-start">
            <a href="{{ route('Student.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
