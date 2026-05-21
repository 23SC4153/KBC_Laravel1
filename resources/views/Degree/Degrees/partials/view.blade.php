<div class="row g-3">
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Degree Name</label>
            <div class="fw-semibold">{{ $degree->DegreeName }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Degree Code</label>
            <div class="fw-semibold">{{ $degree->DegreeCode }}</div>
        </div>
    </div>
    <div class="col-12">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Description</label>
            <div class="fw-semibold">{{ $degree->Description ?: 'No description provided.' }}</div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="border rounded-3 p-3 bg-light">
            <label class="form-label mb-1">Subjects</label>
            <div class="fw-semibold">{{ $degree->subjects->count() ? $degree->subjects->pluck('SubjectName')->join(', ') : 'No subjects assigned.' }}</div>
        </div>
    </div>
</div>
