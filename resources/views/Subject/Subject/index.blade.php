@extends('Student.Student.MainLayout')

@section('page_title', 'Subjects')

@section('title')
    <h1>
        <span>Subject</span> <span>Management</span>
    </h1>
    <div class="hero-divider">
        <span>Manage all subjects across degree programs</span>
    </div>
@endsection

@push('styles')
<style>
    /* Subjects Page Styles */
    .subjects-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .subjects-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--tx-primary);
        margin: 0;
        letter-spacing: 0.5px;
    }

    .btn-add-subject {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
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

    .btn-add-subject:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    /* Alert */
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.4s ease;
        border-left: 4px solid;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #f0fdf4;
        border-color: #86efac;
        color: #15803d;
    }

    .subjects-table-wrap {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-card);
        overflow-x: auto;
        margin-bottom: 32px;
    }

    .subjects-table {
        width: 100%;
        min-width: 940px; /* match students table width for consistency */
        border-collapse: separate;
        border-spacing: 0;
    }

    .subjects-table thead th {
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

    .subjects-table tbody td {
        padding: 14px;
        border-bottom: 1px solid var(--border-mid);
        color: var(--tx-primary);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .subjects-table tbody tr:last-child td {
        border-bottom: none;
    }

    .subjects-table tbody tr:hover td {
        background: var(--gold-dim);
    }

    .subject-code {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-family: var(--font-display);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        background: rgba(184, 134, 11, 0.10);
        color: var(--gold);
        border: 1px solid rgba(184, 134, 11, 0.24);
        white-space: nowrap;
    }

    .subject-code i {
        font-size: 0.6rem;
    }

    .degree-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-family: var(--font-display);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        background: rgba(184, 134, 11, 0.10);
        color: var(--gold);
        border: 1px solid rgba(184, 134, 11, 0.24);
        white-space: nowrap;
    }

    .degree-badge i {
        font-size: 0.6rem;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }

    .btn-view,
    .btn-edit,
    .btn-delete {
        background: var(--bg-card-alt);
        color: var(--tx-primary);
        border: 1px solid var(--border-mid);
    }

    .btn-view:hover,
    .btn-edit:hover,
    .btn-delete:hover {
        background: var(--gold-dim);
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-card);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--tx-muted);
        margin-bottom: 16px;
    }

    .empty-state h3 {
        color: var(--tx-primary);
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .empty-state p {
        color: var(--tx-secondary);
        margin: 0 0 24px 0;
        font-size: 0.95rem;
    }

    .empty-state .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--bg-card-alt);
        color: var(--tx-primary);
        border: 1px solid var(--border-gold);
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

    .empty-state .btn:hover {
        background: var(--bg-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="subjects-header">
        <h2 class="subjects-title">All Subjects</h2>
        <button class="btn-add-subject" data-ajax-modal data-url="{{ route('Subject.create') }}" data-title="Add Subject" type="button">
            <i class="fas fa-plus"></i>
            Add Subject
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($subjects->count() > 0)
        <div class="subjects-table-wrap">
            <table class="subjects-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Degree Program</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="subject-code">
                                    <i class="fas fa-book"></i>
                                    {{ $subject->SubjectCode }}
                                </span>
                            </td>
                            <td>{{ $subject->SubjectName }}</td>
                            <td>
                                <span class="degree-badge">
                                    <i class="fas fa-graduation-cap"></i>
                                    {{ $subject->degree->DegreeCode ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ Str::limit($subject->Description, 50) }}</td>
                            <td>
                                <div class="action-buttons justify-content-end">
                                    <button type="button" class="btn-action btn-view" title="View" data-ajax-modal data-url="{{ route('Subject.show', $subject->id) }}" data-title="Subject Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-action btn-edit" title="Edit" data-ajax-modal data-url="{{ route('Subject.edit', $subject->id) }}" data-title="Edit Subject">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-action btn-delete" title="Delete" data-ajax-delete data-url="{{ route('Subject.destroy', $subject->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <h3>No Subjects Found</h3>
            <p>Start by creating a new subject</p>
            <a href="{{ route('Subject.create') }}" class="btn" data-ajax-modal data-url="{{ route('Subject.create') }}" data-title="Add Subject">
                <i class="fas fa-plus"></i>
                Create Your First Subject
            </a>
        </div>
    @endif
</div>
@endsection
