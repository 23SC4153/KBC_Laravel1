<div class="row g-3">
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Username</label>
            <div class="fw-semibold">{{ $user->username }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Email</label>
            <div class="fw-semibold">{{ $user->email }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Role</label>
            <div class="fw-semibold">{{ ucfirst($user->role) }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Status</label>
            <div class="fw-semibold">{{ $user->is_active ? 'Active' : 'Inactive' }}</div>
        </div>
    </div>
    <div class="col-12">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Linked Record</label>
            <div class="fw-semibold">
                @if($user->student)
                    Student: {{ $user->student->fname }} {{ $user->student->lname }}
                @elseif($user->teacher)
                    Teacher: {{ $user->teacher->fname }} {{ $user->teacher->lname }}
                @else
                    None
                @endif
            </div>
        </div>
    </div>
</div>
