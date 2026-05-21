@extends('Student.Student.MainLayout')

@section('page_title', 'Academic Degrees')

@section('title')
    <h1>
        <span class="divine">Degree</span> <span class="demon">Programs</span>
    </h1>
    <div class="hero-divider">
        <span>Manage all academic degree programs</span>
    </div>
@endsection

@push('styles')
<style>
    /* Degrees Page Styles */
    .degrees-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .degrees-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: var(--tx-primary);
        margin: 0;
        letter-spacing: 0.5px;
    }

    .btn-add-degree {
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

    .btn-add-degree:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
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

    .degrees-table-wrap {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-card);
        overflow-x: auto;
        margin-bottom: 32px;
    }

    .degrees-table {
        width: 100%;
        min-width: 760px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .degrees-table thead th {
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

    .degrees-table tbody td {
        padding: 14px;
        border-bottom: 1px solid rgba(184, 134, 11, 0.12);
        color: var(--tx-primary);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .degrees-table tbody tr:last-child td {
        border-bottom: none;
    }

    .degrees-table tbody tr:hover td {
        background: var(--gold-dim);
    }

    .degree-code {
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
        background: rgba(184, 134, 11, 0.1);
        color: var(--gold);
        border: 1px solid rgba(184, 134, 11, 0.24);
        white-space: nowrap;
    }

    .degree-code i {
        font-size: 0.65rem;
    }

    .degree-name {
        font-family: var(--font-display);
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        color: var(--tx-primary);
    }

    .degree-actions {
        display: flex;
        gap: 8px;
        min-width: 240px;
    }

    .action-link {
        flex: 1;
        display: flex;
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

    .action-link:hover {
        background: var(--gold-dim);
        border-color: var(--gold);
        color: var(--gold);
    }

    .action-link.delete {
        border-color: rgba(192, 57, 43, 0.3);
        color: var(--red);
    }

    .action-link.delete:hover {
        background: rgba(192, 57, 43, 0.08);
        border-color: var(--red);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border-gold);
    }

    .empty-state-icon {
        font-size: 48px;
        color: var(--gold-mid);
        margin-bottom: 16px;
        display: block;
    }

    .empty-state-text {
        font-size: 16px;
        color: var(--tx-muted);
        margin: 0 0 24px;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--gold-dim);
        color: var(--gold);
        border: 1px solid var(--gold);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .empty-state-btn:hover {
        background: var(--gold);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .degrees-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add-degree {
            width: 100%;
            justify-content: center;
        }

        .degrees-table {
            min-width: 700px;
        }
    }

    @media (max-width: 480px) {
        .degree-actions {
            min-width: 210px;
        }
    }
</style>
@endpush

@section('content')

{{-- Alert Messages --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- Header --}}
<div class="degrees-header">
    <h2 class="degrees-title">
        <i class="fas fa-graduation-cap"></i> Degree Programs
    </h2>
    <a href="{{ route('Degree.create') }}" class="btn-add-degree" data-ajax-modal data-url="{{ route('Degree.create') }}" data-title="Add Degree">
        <i class="fas fa-plus"></i> Add Degree
    </a>
</div>

{{-- Degrees Table --}}
@forelse($degrees as $degree)
    @if($loop->first)
        <div class="degrees-table-wrap">
            <table class="degrees-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Degree Code</th>
                        <th>Degree Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
    @endif
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="degree-code">
                                <i class="fas fa-book"></i>
                                {{ $degree->DegreeCode }}
                            </span>
                        </td>
                        <td>
                            <p class="degree-name">{{ $degree->DegreeName }}</p>
                        </td>
                        <td>
                            <div class="degree-actions justify-content-end">
                                <button type="button" class="action-link" data-ajax-modal data-url="{{ route('Degree.show', $degree->id) }}" data-title="Degree Details">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button type="button" class="action-link" data-ajax-modal data-url="{{ route('Degree.edit', $degree->id) }}" data-title="Edit Degree">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="action-link delete" data-ajax-delete data-url="{{ route('Degree.destroy', $degree->id) }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
    @if($loop->last)
                </tbody>
            </table>
        </div>
    @endif
@empty
    <div class="empty-state">
        <i class="fas fa-book-open empty-state-icon"></i>
        <p class="empty-state-text">No degree programs available yet</p>
        <a href="{{ route('Degree.create') }}" class="empty-state-btn">
            <i class="fas fa-plus"></i> Create First Degree
        </a>
    </div>
@endforelse

@endsection
