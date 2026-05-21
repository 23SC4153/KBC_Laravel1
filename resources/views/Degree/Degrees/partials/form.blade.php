<form action="{{ isset($degree) ? route('Degree.update', $degree->id) : route('Degree.store') }}" method="POST">
    @csrf
    @if(isset($degree))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">Degree Name *</label>
        <input type="text" name="DegreeName" class="form-control @error('DegreeName') is-invalid @enderror" value="{{ old('DegreeName', $degree->DegreeName ?? '') }}" required>
        @error('DegreeName')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Degree Code *</label>
        <input type="text" name="DegreeCode" class="form-control @error('DegreeCode') is-invalid @enderror" value="{{ old('DegreeCode', $degree->DegreeCode ?? '') }}" required>
        @error('DegreeCode')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="Description" class="form-control @error('Description') is-invalid @enderror" rows="4">{{ old('Description', $degree->Description ?? '') }}</textarea>
        @error('Description')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-primary">{{ isset($degree) ? 'Update Degree' : 'Create Degree' }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
