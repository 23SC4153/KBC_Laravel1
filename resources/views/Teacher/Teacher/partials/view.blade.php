<div class="row g-3">
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
            <label class="form-label mb-1">First Name</label>
            <div class="fw-semibold">{{ $teacher->fname }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
            <label class="form-label mb-1">Last Name</label>
            <div class="fw-semibold">{{ $teacher->lname }}</div>
        </div>
    </div>

    @if($teacher->mname)
        <div class="col-12">
            <div class="border rounded-3 p-3" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                <label class="form-label mb-1">Middle Name</label>
                <div class="fw-semibold">{{ $teacher->mname }}</div>
            </div>
        </div>
    @endif

    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
            <label class="form-label mb-1">Email Address</label>
            <div class="fw-semibold">
                <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
            <label class="form-label mb-1">Contact Number</label>
            <div class="fw-semibold">
                <a href="tel:{{ $teacher->contact }}">{{ $teacher->contact }}</a>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="border rounded-3 p-3" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
            <label class="form-label mb-1">Specialization</label>
            <div class="fw-semibold">{{ $teacher->specialization ?? 'Not specified' }}</div>
        </div>
    </div>

    @if($teacher->userAccount)
        <div class="col-12">
            <hr class="mt-4">
            <h6 class="mb-3">User Account Information</h6>
        </div>

        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                <label class="form-label mb-1">Username</label>
                <div class="fw-semibold">{{ $teacher->userAccount->username }}</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                <label class="form-label mb-1">Role</label>
                <div class="fw-semibold">
                    <span class="badge bg-info">{{ ucfirst($teacher->userAccount->role) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                <label class="form-label mb-1">Account Status</label>
                <div class="fw-semibold">
                    @if($teacher->userAccount->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                <label class="form-label mb-1">Account Created</label>
                <div class="fw-semibold">{{ $teacher->userAccount->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    @endif
</div>
