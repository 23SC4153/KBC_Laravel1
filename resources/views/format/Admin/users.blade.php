@extends('Student.Student.MainLayout')
@section('title')
    <h1>User Management</h1>
@endsection
@section('subtitle')
    Manage system users and permissions
@endsection
@section('content')
<div class="container" style="padding: 30px 0;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0; color: var(--tx-primary);">System Users</h2>
        <a href="{{ route('admin.dashboard') }}" style="padding: 10px 20px; background: var(--border-gold); color: var(--tx-primary); text-decoration: none; border-radius: 6px; font-weight: 600;">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($users->isEmpty())
        <div style="background: var(--bg-card); padding: 40px; text-align: center; border-radius: 8px;">
            <p style="color: var(--tx-muted);">No users found.</p>
        </div>
    @else
        <div style="background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border-gold); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--bg-card-alt);">
                    <tr>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid var(--border-gold);">Username</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid var(--border-gold);">Email</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid var(--border-gold);">Role</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid var(--border-gold);">Name</th>
                        <th style="padding: 15px; text-align: left; border-bottom: 1px solid var(--border-gold);">Status</th>
                        <th style="padding: 15px; text-align: center; border-bottom: 1px solid var(--border-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr style="border-bottom: 1px solid var(--border-gold);">
                        <td style="padding: 15px;">{{ $user->username }}</td>
                        <td style="padding: 15px;">{{ $user->email }}</td>
                        <td style="padding: 15px;">
                            <span style="display: inline-block; padding: 4px 12px; background: {{ $user->role === 'admin' ? '#ef4444' : ($user->role === 'teacher' ? '#8b5cf6' : '#3b82f6') }}; color: white; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            @if ($user->student)
                                {{ $user->student->fname }} {{ $user->student->lname }}
                            @elseif ($user->teacher)
                                {{ $user->teacher->fname }} {{ $user->teacher->lname }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <span style="color: {{ $user->is_active ? '#10b981' : '#ef4444' }};font-weight: 600;">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <form method="POST" action="{{ route('admin.toggleUserStatus', $user->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="padding: 6px 12px; background: {{ $user->is_active ? '#ef4444' : '#10b981' }}; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
