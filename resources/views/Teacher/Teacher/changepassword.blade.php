@extends('Student.Student.MainLayout')
@section('title')
    <h1>Change Password</h1>
@endsection
@section('subtitle')
    Update teacher account password
@endsection
@section('content')
<div class="container" style="max-width: 500px; padding: 30px 0;">
    <div style="background: var(--bg-card); padding: 30px; border-radius: 12px; border: 1px solid var(--border-gold);">
        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('Teacher.updatePassword', $teacher->id) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Teacher: {{ $teacher->fname }} {{ $teacher->lname }}</label>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">New Password *</label>
                <input type="password" name="password" id="password" required style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; color: var(--tx-primary); font-weight: 600;">Confirm Password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid var(--border-gold); border-radius: 6px; font-family: inherit;">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" style="flex: 1; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer;">Update Password</button>
                <a href="{{ route('Teacher.index') }}" style="flex: 1; padding: 12px; background: var(--border-gold); color: var(--tx-primary); border: none; border-radius: 6px; font-size: 16px; font-weight: 600; text-decoration: none; text-align: center;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
