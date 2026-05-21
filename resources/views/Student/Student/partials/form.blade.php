<form action="{{ isset($student) ? route('Student.update', $student->id) : route('Student.store') }}" method="POST">
    @csrf
    @if(isset($student))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">First Name *</label>
        <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname', isset($student) ? $student->fname : '') }}" required>
        @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Middle Name</label>
        <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname', isset($student) ? $student->mname : '') }}">
        @error('mname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Last Name *</label>
        <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname', isset($student) ? $student->lname : '') }}" required>
        @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Username *</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', isset($student) ? optional($student->userAccount)->username : '') }}" required>
        @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($student) ? $student->email : '') }}" required>
        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Contact (11 digits) *</label>
        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', isset($student) ? $student->contact : '') }}" placeholder="09xxxxxxxxx" required>
        @error('contact')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    @if(isset($degrees) && $degrees->count())
        <div class="mb-3">
            <label class="form-label">Degree *</label>
            <select name="degree_id" class="form-control @error('degree_id') is-invalid @enderror" required>
                <option value="">Select Degree</option>
                @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}" {{ old('degree_id', isset($student) ? $student->degree_id : '') == $degree->id ? 'selected' : '' }}>{{ $degree->DegreeCode }}</option>
                @endforeach
            </select>
            @error('degree_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Password {{ isset($student) ? '(leave blank to keep current)' : '*' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ isset($student) ? '' : 'required' }}>
        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password {{ isset($student) ? '' : '*' }}</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-primary">{{ isset($student) ? 'Update Student' : 'Add Student' }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
