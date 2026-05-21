@extends('Student.Student.MainLayout')
@section('title')
    <h1>Teacher Dashboard</h1>
@endsection
@section('subtitle')
    Your teaching overview
@endsection
@section('hero_tagline')
    Welcome back, {{ $teacher->fname }}
@endsection
@section('content')
<div class="container" style="padding: 30px 0;">
    
    <!-- Profile Summary -->
    <div class="card" style="padding: 30px; border-radius: 12px; margin-bottom: 30px;">
        <div class="card-ember"></div>
        <h2 style="margin-top: 0;">{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</h2>
        <p style="margin: 10px 0; opacity: 0.9;">Specialization: {{ $teacher->specialization ?? 'General Teaching' }}</p>
        <p style="margin: 0; opacity: 0.9;">{{ $teacher->email }}</p>
    </div>

    <!-- Statistics Grid -->
    <div class="stat-grid" style="margin-bottom:30px;">
        <div class="stat-card">
            <div class="stat-value">{{ $teacher->courses->count() ?? 0 }}</div>
            <div class="stat-label">Total Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">0</div>
            <div class="stat-label">Total Students</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $teacher->userAccount->is_active ? 'Active' : 'Inactive' }}</div>
            <div class="stat-label">Account Status</div>
        </div>
    </div>

    <!-- Teacher Information -->
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 30px;">
        <h3 style="margin-top: 0; color: var(--tx-primary);">Teacher Information</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            
            <div>
                <p style="margin: 0 0 5px; color: var(--tx-muted); font-size: 0.9rem;">Email</p>
                <p style="margin: 0; font-weight: 600;">{{ $teacher->email }}</p>
            </div>

            <div>
                <p style="margin: 0 0 5px; color: var(--tx-muted); font-size: 0.9rem;">Contact</p>
                <p style="margin: 0; font-weight: 600;">{{ $teacher->contact }}</p>
            </div>

            <div>
                <p style="margin: 0 0 5px; color: var(--tx-muted); font-size: 0.9rem;">Specialization</p>
                <p style="margin: 0; font-weight: 600;">{{ $teacher->specialization ?? 'Not specified' }}</p>
            </div>

            <div>
                <p style="margin: 0 0 5px; color: var(--tx-muted); font-size: 0.9rem;">Member Since</p>
                <p style="margin: 0; font-weight: 600;">{{ $teacher->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('Teacher.edit', $teacher->id) }}" class="btn btn-outline-secondary" style="padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;">Edit Profile</a>
        <a href="{{ route('Teacher.changePasswordForm', $teacher->id) }}" class="btn btn-outline-secondary" style="padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;">Change Password</a>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary" style="padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;">Back to Dashboard</a>
    </div>

</div>
@endsection
