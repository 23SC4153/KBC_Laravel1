<div class="row g-3">
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
            <label class="form-label mb-1">Subject Name</label>
            <div class="fw-semibold">{{ $subject->SubjectName }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
            <label class="form-label mb-1">Subject Code</label>
            <div class="fw-semibold">{{ $subject->SubjectCode }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
            <label class="form-label mb-1">Degree Program</label>
            <div class="fw-semibold">{{ $subject->degree->DegreeName ?? 'N/A' }}</div>
            <small class="text-muted">{{ $subject->degree->DegreeCode ?? 'N/A' }}</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100" style="background: rgba(192,57,43,0.03); border-color: rgba(192,57,43,0.15) !important;">
            <label class="form-label mb-1">Created Date</label>
            <div class="fw-semibold">{{ $subject->created_at->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="col-12">
        <div class="border rounded-3 p-3" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
            <label class="form-label mb-1">Description</label>
            <div class="fw-semibold">{{ $subject->Description ?: 'No description provided' }}</div>
        </div>
    </div>
</div>
