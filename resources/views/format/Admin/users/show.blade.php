@extends('Student.Student.MainLayout')
@section('title')
    <h1>User Details</h1>
@endsection
@section('subtitle')
    View user account information
@endsection
@push('styles')
<style>
    .user-details-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:20px; margin:20px 0; }
    .detail-card { background:var(--bg-card); padding:16px; border-radius:12px; border:1px solid var(--border-gold); }
    .detail-label { font-family:var(--font-display); font-size:0.72rem; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); margin-bottom:6px; font-weight:600; }
    .detail-value { font-size:1rem; color:var(--tx-primary); font-weight:500; }
    .role-badge { display:inline-block; padding:6px 14px; background:rgba(184,134,11,0.1); color:var(--gold); border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; }
    .role-badge.admin { background:rgba(192,57,43,0.1); color:var(--red); }
    .role-badge.teacher { background:rgba(41,128,185,0.1); color:#2980b9; }
    .status-badge { display:inline-block; padding:6px 14px; background:rgba(16,185,129,0.1); color:#10b981; border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; }
    .status-badge.inactive { background:rgba(239,68,68,0.1); color:#ef4444; }
    .user-profile-section { background:var(--bg-card-alt); padding:20px; border-radius:12px; border:1px solid var(--border-mid); margin-bottom:20px; }
    .btn-edit { background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%); color:white; border:none; padding:11px 22px; border-radius:8px; font-weight:600; text-decoration:none; cursor:pointer; }
    .btn-back { background:var(--bg-card-alt); color:var(--tx-primary); border:1px solid var(--border-mid); padding:11px 22px; border-radius:8px; font-weight:600; text-decoration:none; }
    .action-buttons { display:flex; gap:12px; margin-top:20px; }
</style>
@endpush
@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <!-- User Header -->
        <div class="user-profile-section">
            <h2 style="margin:0 0 12px; color:var(--tx-primary);">
                <i class="fas fa-user-circle"></i> {{ $user->username }}
            </h2>
            <p style="margin:0; color:var(--tx-muted);">{{ $user->email }}</p>
        </div>

        <!-- Main Details -->
        <div class="user-details-grid">
            <div class="detail-card">
                <div class="detail-label">Role</div>
                <div class="detail-value">
                    <span class="role-badge {{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="status-badge {{ !$user->is_active ? 'inactive' : '' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Account Created</div>
                <div class="detail-value">{{ $user->created_at->format('F d, Y') }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Last Updated</div>
                <div class="detail-value">{{ $user->updated_at->format('F d, Y H:i') }}</div>
            </div>
        </div>

        <!-- Related Records -->
        @if($user->student)
        <div style="margin-top:20px;">
            <h3 style="color:var(--tx-primary); margin-bottom:12px;">
                <i class="fas fa-user-graduate"></i> Student Record
            </h3>
            <div class="detail-card">
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px;">
                    <div>
                        <div class="detail-label">First Name</div>
                        <div class="detail-value">{{ $user->student->fname }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Middle Name</div>
                        <div class="detail-value">{{ $user->student->mname ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Last Name</div>
                        <div class="detail-value">{{ $user->student->lname }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($user->teacher)
        <div style="margin-top:20px;">
            <h3 style="color:var(--tx-primary); margin-bottom:12px;">
                <i class="fas fa-chalkboard-user"></i> Teacher Record
            </h3>
            <div class="detail-card">
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px;">
                    <div>
                        <div class="detail-label">First Name</div>
                        <div class="detail-value">{{ $user->teacher->fname }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Middle Name</div>
                        <div class="detail-value">{{ $user->teacher->mname ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Last Name</div>
                        <div class="detail-value">{{ $user->teacher->lname }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Specialization</div>
                        <div class="detail-value">{{ $user->teacher->specialization ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="action-buttons">
            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-edit">
                <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('admin.user.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
@endsection
