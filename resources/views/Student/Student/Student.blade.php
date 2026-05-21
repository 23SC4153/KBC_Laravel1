@extends('Student.Student.MainLayout')
@section('title')
    <h1>Students</h1>
@endsection
@section('subtitle')
    Manage student records, account status, and course assignments in one view.
@endsection
@section('hero_tagline')
    Discipline in detail
@endsection
@push('styles')
<style>
    .students-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .students-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--tx-primary);
        margin: 0;
        letter-spacing: 0.5px;
    }

    .students-count {
        font-size: 0.92rem;
        color: var(--tx-muted);
        margin: 4px 0 0;
    }

    .btn-add-student {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: var(--font-display);
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .btn-add-student:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .students-table-wrap {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-card);
        overflow-x: auto;
        margin-bottom: 32px;
    }

    .students-table {
        width: 100%;
        min-width: 940px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .students-table thead th {
        padding: 13px 14px;
        background: var(--bg-card-alt);
        color: var(--tx-muted);
        font-family: var(--font-display);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-mid);
        white-space: nowrap;
    }

    .students-table tbody td {
        padding: 14px;
        border-bottom: 1px solid rgba(184, 134, 11, 0.12);
        color: var(--tx-primary);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .students-table tbody tr:last-child td {
        border-bottom: none;
    }

    .students-table tbody tr:hover td {
        background: var(--gold-dim);
    }

    .student-name {
        font-family: var(--font-display);
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        color: var(--tx-primary);
    }

    .student-mname {
        color: var(--tx-muted);
        font-size: 0.9rem;
    }

    .student-actions {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
        min-width: 240px;
    }

    .student-action {
        flex: 1 1 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border: 1px solid var(--border-mid);
        border-radius: 6px;
        background: var(--bg-card-alt);
        color: var(--tx-primary);
        text-decoration: none;
        font-size: 0.74rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: var(--font-display);
        letter-spacing: 0.3px;
    }

    .student-action:hover {
        background: var(--gold-dim);
        border-color: var(--gold);
        color: var(--gold);
    }

    .student-action.delete {
        border-color: rgba(192, 57, 43, 0.3);
        color: var(--red);
    }

    .student-action.delete:hover {
        background: rgba(192, 57, 43, 0.08);
        border-color: var(--red);
        color: var(--red);
    }

    .student-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-family: var(--font-display);
        font-weight: 700;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        border: 1px solid transparent;
    }

    .student-chip.degree {
        background: rgba(184, 134, 11, 0.1);
        color: var(--gold);
        border-color: rgba(184, 134, 11, 0.24);
    }

    .student-chip.active {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        border-color: rgba(25, 135, 84, 0.24);
    }

    .student-chip.inactive {
        background: rgba(220, 53, 69, 0.08);
        color: #b02a37;
        border-color: rgba(220, 53, 69, 0.22);
    }

    .student-chip.na {
        background: rgba(255, 193, 7, 0.14);
        color: #8a6100;
        border-color: rgba(255, 193, 7, 0.26);
    }

    .students-empty {
        text-align: center;
        padding: 60px 24px;
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
    }

    .students-empty-icon {
        font-size: 48px;
        color: var(--gold-mid);
        margin-bottom: 16px;
        display: block;
    }

    .students-empty-text {
        font-size: 16px;
        color: var(--tx-muted);
        margin: 0 0 24px;
    }

    @media (max-width: 768px) {
        .students-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-student {
            width: 100%;
            justify-content: center;
        }

        .students-table {
            min-width: 820px;
        }
    }
</style>
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
                <p class="text-uppercase small mb-1" style="letter-spacing: .18em; color: var(--tx-muted);">Student Registry</p>
                <h4 class="students-title">Students</h4>
                <div class="students-count">{{ $Students->count() }} record(s) currently listed.</div>
            </div>
            <button class="btn-add-student" data-ajax-modal data-url="{{ route('Student.create') }}" data-title="Add Student" type="button">
                <i class="fas fa-plus"></i> Add Student
            </button>
        </div>

        @if($Students->count())
            <div class="students-table-wrap">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Degree</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($Students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><p class="student-name">{{ $student->fname }}</p></td>
                                <td><span class="student-mname">{{ $student->mname ?: '—' }}</span></td>
                                <td>{{ $student->lname }}</td>
                                <td>
                                    <span class="student-chip degree">
                                        <i class="fas fa-layer-group"></i>
                                        {{ optional($student->degree)->DegreeCode ?? 'Unassigned' }}
                                    </span>
                                </td>
                                <td>
                                    @if($student->userAccount)
                                        @if($student->userAccount->is_active)
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
                                        <button type="button" class="student-action" data-ajax-modal data-url="{{ route('Student.show', $student->id) }}" data-title="Student Details">
                                            View
                                        </button>
                                        <button type="button" class="student-action" data-ajax-modal data-url="{{ route('Student.edit', $student->id) }}" data-title="Edit Student">
                                            Edit
                                        </button>
                                        <button type="button" class="student-action delete" data-ajax-delete data-url="{{ route('Student.destroy', $student->id) }}">
                                            Delete
                                        </button>
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
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h4 class="mb-2">No students available.</h4>
                <p class="students-empty-text">Add the first student to populate this list.</p>
                <button class="btn-add-student" data-ajax-modal data-url="{{ route('Student.create') }}" data-title="Add Student" type="button">
                    <i class="fas fa-plus"></i> Add Student
                </button>
            </div>
        @endif
    </div>

@endsection
