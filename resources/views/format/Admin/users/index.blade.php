@extends('Student.Student.MainLayout')
@section('title')
    <h1>User Management</h1>
@endsection
@section('subtitle')
    Create, manage, and assign roles to system users
@endsection
@push('styles')
<style>
    .users-header { display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:28px; }
    .users-title { font-family:var(--font-display); font-size:18px; font-weight:700; color:var(--tx-primary); margin:0; }
    .btn-add-user { display:inline-flex; align-items:center; gap:8px; padding:11px 22px; background:linear-gradient(135deg,#10b981 0%,#059669 100%); color:white; border:none; border-radius:8px; font-size:0.9rem; font-weight:600; text-decoration:none; }
    .users-table-wrap { background:var(--bg-card); border-radius:12px; border:1px solid var(--border-gold); box-shadow:var(--shadow-card); overflow-x:auto; margin-bottom:32px; }
    .users-table { width:100%; min-width:940px; border-collapse:separate; border-spacing:0; }
    .users-table thead th { padding:13px 14px; background:var(--bg-card-alt); color:var(--tx-muted); font-family:var(--font-display); font-size:0.68rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; border-bottom:1px solid var(--border-mid); white-space:nowrap; }
    .users-table tbody td { padding:14px; border-bottom:1px solid rgba(184,134,11,0.12); color:var(--tx-primary); font-size:0.95rem; vertical-align:middle; }
    .user-actions { display:flex; gap:8px; flex-wrap:nowrap; }
    .user-action { display:inline-flex; align-items:center; justify-content:center; padding:9px 12px; border:1px solid var(--border-mid); border-radius:6px; background:var(--bg-card-alt); color:var(--tx-primary); text-decoration:none; font-size:0.74rem; font-weight:600; }
    .user-action.delete { border-color:rgba(192,57,43,0.3); color:var(--red); }
    .role-badge { display:inline-block; padding:4px 12px; background:rgba(184,134,11,0.1); color:var(--gold); border-radius:999px; font-size:0.72rem; font-weight:700; text-transform:uppercase; }
    .role-badge.admin { background:rgba(192,57,43,0.1); color:var(--red); }
    .role-badge.teacher { background:rgba(41,128,185,0.1); color:#2980b9; }
    .status-active { color:#10b981; font-weight:600; }
    .status-inactive { color:#ef4444; font-weight:600; }
    .users-empty { text-align:center; padding:60px 24px; background:var(--bg-card); border-radius:12px; border:1px solid var(--border-gold); }
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

        <div class="users-header">
            <div>
                <p class="text-uppercase small mb-1" style="letter-spacing:.18em; color:var(--tx-muted);">User Registry</p>
                <h4 class="users-title">System Users</h4>
                <div class="users-count">{{ $users->count() }} record(s) currently listed.</div>
            </div>
            <div style="display:flex;gap:12px;align-items:center;">
                <a href="{{ route('admin.user.create') }}" class="btn-add-user" data-ajax-modal data-url="{{ route('admin.user.create') }}" data-title="Create User">
                    <i class="fas fa-plus"></i> Add User
                </a>
                <button id="autoToggle" class="btn-add-user" type="button" style="padding:8px 14px;font-size:0.85rem;">Auto Refresh</button>
                <input id="autoInterval" type="number" min="200" value="2000" style="width:86px;padding:6px;border-radius:6px;border:1px solid var(--border-mid);font-size:0.85rem;" title="Interval (ms)">
            </div>
        </div>

        @if($users->count())
            <div class="users-table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $user->username }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge {{ $user->role }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-{{ $user->is_active ? 'active' : 'inactive' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->student)
                                        {{ $user->student->fname }} {{ $user->student->lname }}
                                    @elseif($user->teacher)
                                        {{ $user->teacher->fname }} {{ $user->teacher->lname }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div class="user-actions justify-content-end">
                                                <button type="button" class="user-action" data-ajax-modal data-url="{{ route('admin.user.show', $user->id) }}" data-title="User Details">View</button>
                                        <button type="button" class="user-action" data-ajax-modal data-url="{{ route('admin.user.edit', $user->id) }}" data-title="Edit User">Edit</button>
                                        <button type="button" class="user-action delete w-100" data-ajax-delete data-url="{{ route('admin.user.destroy', $user->id) }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="users-empty">
                <div style="font-size:48px; color:var(--gold-mid); margin-bottom:16px;">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="mb-2">No users available.</h4>
                <p style="color:var(--tx-muted); margin:0 0 24px;">Add the first user to populate this list.</p>
                <a href="{{ route('admin.user.create') }}" class="btn-add-user" data-ajax-modal data-url="{{ route('admin.user.create') }}" data-title="Create User">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        @endif
    </div>
    <script>
        (function(){
            const autoBtn = document.getElementById('autoToggle');
            const autoIntervalInput = document.getElementById('autoInterval');
            let autoTimer = null;

            function replaceTableFromHtml(htmlText){
                try{
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(htmlText, 'text/html');
                    const newTbody = doc.querySelector('.users-table tbody');
                    const newCount = doc.querySelector('.users-count');
                    const curTbody = document.querySelector('.users-table tbody');
                    if (newTbody && curTbody) curTbody.innerHTML = newTbody.innerHTML;
                    if (newCount) {
                        const curCount = document.querySelector('.users-count');
                        if (curCount) curCount.textContent = newCount.textContent;
                    }
                }catch(e){
                    console.error('Failed to update users table', e);
                }
            }

            if (!autoBtn || !autoIntervalInput) return;

            autoBtn.addEventListener('click', () => {
                if (autoTimer) {
                    clearInterval(autoTimer);
                    autoTimer = null;
                    autoBtn.textContent = 'Auto Refresh';
                } else {
                    const ms = Math.max(200, parseInt(autoIntervalInput.value, 10) || 2000);
                    autoBtn.textContent = 'Stop Refresh';
                    autoTimer = setInterval(() => {
                        fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(r => r.text())
                            .then(html => replaceTableFromHtml(html))
                            .catch(() => {});
                    }, ms);
                }
            });
        })();
    </script>

@endsection
