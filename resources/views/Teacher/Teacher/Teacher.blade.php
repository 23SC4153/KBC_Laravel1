@extends('Student.Student.MainLayout')
@section('title')
    <h1>Teachers</h1>
@endsection
@section('subtitle')
    Manage teacher records, account status, and assignments.
@endsection
@push('styles')
<style>
    /* Reuse student table styles for consistency */
    .students-header { display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:28px; }
    .students-title { font-family:var(--font-display); font-size:18px; font-weight:700; color:var(--tx-primary); margin:0; }
    .btn-add-student { display:inline-flex; align-items:center; gap:8px; padding:11px 22px; background:linear-gradient(135deg,#10b981 0%,#059669 100%); color:white; border:none; border-radius:8px; font-size:0.9rem; font-weight:600; text-decoration:none; }
    .students-table-wrap { background:var(--bg-card); border-radius:12px; border:1px solid var(--border-gold); box-shadow:var(--shadow-card); overflow-x:auto; margin-bottom:32px; }
    .students-table { width:100%; min-width:940px; border-collapse:separate; border-spacing:0; }
    .students-table thead th { padding:13px 14px; background:var(--bg-card-alt); color:var(--tx-muted); font-family:var(--font-display); font-size:0.68rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; border-bottom:1px solid var(--border-mid); white-space:nowrap; }
    .students-table tbody td { padding:14px; border-bottom:1px solid rgba(184,134,11,0.12); color:var(--tx-primary); font-size:0.95rem; vertical-align:middle; }
    .student-name { font-family:var(--font-display); font-size:0.95rem; font-weight:700; color:var(--tx-primary); }
    .student-actions { display:flex; gap:8px; flex-wrap:nowrap; min-width:240px; }
    .student-action { display:inline-flex; align-items:center; justify-content:center; padding:9px 12px; border:1px solid var(--border-mid); border-radius:6px; background:var(--bg-card-alt); color:var(--tx-primary); text-decoration:none; font-size:0.74rem; font-weight:600; }
    .student-action.delete { border-color:rgba(192,57,43,0.3); color:var(--red); }
    .students-empty { text-align:center; padding:60px 24px; background:var(--bg-card); border-radius:12px; border:1px solid var(--border-gold); }
</style>
</push>
@endpush
@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="students-header">
            <div>
                <p class="text-uppercase small mb-1" style="letter-spacing:.18em; color:var(--tx-muted);">Teacher Registry</p>
                <h4 class="students-title">Teachers</h4>
                <div class="students-count">{{ $teachers->count() }} record(s) currently listed.</div>
            </div>
            <button class="btn-add-student" data-ajax-modal data-url="{{ route('Teacher.create') }}" data-title="Add Teacher" type="button">
                <i class="fas fa-plus"></i> Add Teacher
            </button>
        </div>

        @if($teachers->count())
            <div class="students-table-wrap">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Specialization</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $index => $teacher)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><p class="student-name">{{ $teacher->fname }}</p></td>
                                <td><span class="student-mname">{{ $teacher->mname ?: '—' }}</span></td>
                                <td>{{ $teacher->lname }}</td>
                                <td>
                                    <span class="student-chip degree">
                                        <i class="fas fa-user-tie"></i>
                                        {{ $teacher->specialization ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($teacher->userAccount)
                                        @if($teacher->userAccount->is_active)
                                            <span class="student-chip active">Active</span>
                                        @else
                                            <span class="student-chip inactive">Inactive</span>
                                        @endif
                                    @else
                                        <span class="student-chip na">No Account</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="student-actions justify-content-end">
                                        <button type="button" class="student-action" data-ajax-modal data-url="{{ route('Teacher.show', $teacher->id) }}" data-title="Teacher Details">View</button>
                                        <button type="button" class="student-action" data-ajax-modal data-url="{{ route('Teacher.edit', $teacher->id) }}" data-title="Edit Teacher">Edit</button>
                                        <button type="button" class="student-action delete" data-ajax-delete data-url="{{ route('Teacher.destroy', $teacher->id) }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="students-empty">
                <div class="students-empty-icon">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <h4 class="mb-2">No teachers available.</h4>
                <p class="students-empty-text">Add the first teacher to populate this list.</p>
                <a href="{{ route('Teacher.create') }}" class="btn-add-student">
                    <i class="fas fa-plus"></i> Add Teacher
                </a>
            </div>
        @endif
    </div>
@endsection
