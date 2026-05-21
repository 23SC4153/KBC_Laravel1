<form action="{{ isset($subject) ? route('Subject.update', $subject->id) : route('Subject.store') }}" method="POST" novalidate>
    @csrf
    @if(isset($subject))
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label for="degree_id" class="form-label">Degree Program <span class="text-danger">*</span></label>
            <select id="degree_id" name="degree_id" class="form-control @error('degree_id') is-invalid @enderror" required>
                <option value="">Select a degree program</option>
                @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}" {{ old('degree_id', $subject->degree_id ?? '') == $degree->id ? 'selected' : '' }}>
                        {{ $degree->DegreeName }} ({{ $degree->DegreeCode }})
                    </option>
                @endforeach
            </select>
            @error('degree_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="SubjectCode" class="form-label">Subject Code <span class="text-danger">*</span></label>
            <input
                id="SubjectCode"
                type="text"
                name="SubjectCode"
                class="form-control @error('SubjectCode') is-invalid @enderror"
                value="{{ old('SubjectCode', $subject->SubjectCode ?? '') }}"
                placeholder="e.g., CS101"
                required
            >
            @error('SubjectCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="SubjectName" class="form-label">Subject Name <span class="text-danger">*</span></label>
            <input
                id="SubjectName"
                type="text"
                name="SubjectName"
                class="form-control @error('SubjectName') is-invalid @enderror"
                value="{{ old('SubjectName', $subject->SubjectName ?? '') }}"
                placeholder="e.g., Introduction to Programming"
                required
            >
            @error('SubjectName')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="Description" class="form-label">Description</label>
            <textarea
                id="Description"
                name="Description"
                class="form-control @error('Description') is-invalid @enderror"
                rows="4"
                placeholder="Subject description..."
            >{{ old('Description', $subject->Description ?? '') }}</textarea>
            @error('Description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="d-flex gap-3 mt-4">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>
            {{ isset($subject) ? 'Update Subject' : 'Create Subject' }}
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>
            Cancel
        </button>
    </div>
</form>
