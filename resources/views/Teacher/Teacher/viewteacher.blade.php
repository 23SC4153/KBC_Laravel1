@extends('Student.Student.MainLayout')
@section('title')
    <h1>Teacher Details</h1>
@endsection
@section('subtitle')
    View teacher information
@endsection
@section('content')
<div class="container" style="max-width: 600px; padding: 30px 0;">
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold); margin-bottom: 20px;">
        <h2 style="margin-top: 0; color: var(--tx-primary);">{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</h2>

        <div style="margin: 20px 0;">
            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 15px;">
                <strong>Email:</strong>
                <span>{{ $teacher->email }}</span>

                <strong>Contact:</strong>
                <span>{{ $teacher->contact }}</span>

                <strong>Specialization:</strong>
                <span>{{ $teacher->specialization ?? 'Not specified' }}</span>

                <strong>Username:</strong>
                <span>{{ $teacher->userAccount->username ?? 'N/A' }}</span>

                <strong>Status:</strong>
                <span style="color: {{ $teacher->userAccount->is_active ? '#10b981' : '#ef4444' }};">
                    {{ $teacher->userAccount->is_active ? 'Active' : 'Inactive' }}
                </span>

                <strong>Joined:</strong>
                <span>{{ $teacher->created_at->format('F d, Y') }}</span>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <a href="{{ route('Teacher.edit', $teacher->id) }}" style="flex: 1; padding: 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; text-decoration: none; text-align: center;">Edit</a>
            <a href="{{ route('Teacher.changePasswordForm', $teacher->id) }}" style="flex: 1; padding: 12px; background: #8b5cf6; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; text-decoration: none; text-align: center;">Change Password</a>
            <a href="{{ route('Teacher.index') }}" style="flex: 1; padding: 12px; background: var(--border-gold); color: var(--tx-primary); border: none; border-radius: 6px; font-size: 16px; font-weight: 600; text-decoration: none; text-align: center;">Back</a>
        </div>
    </div>
</div>
@endsection
