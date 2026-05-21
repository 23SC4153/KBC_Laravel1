<form action="{{ isset($teacher) ? route('Teacher.update', $teacher->id) : route('Teacher.store') }}" method="POST">
    @csrf
    @if(isset($teacher))
        @method('PUT')
    @endif
    
    <div class="mb-3">
        <label class="form-label">First Name *</label>
        <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname', $teacher->fname ?? '') }}" required>
        @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Middle Name</label>
        <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname', $teacher->mname ?? '') }}">
        @error('mname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Last Name *</label>
        <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname', $teacher->lname ?? '') }}" required>
        @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Username *</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $teacher->userAccount->username ?? '') }}" required>
        @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $teacher->email ?? '') }}" required>
        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Contact (11 digits) *</label>
        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $teacher->contact ?? '') }}" placeholder="09xxxxxxxxx" required>
        @error('contact')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $teacher->specialization ?? '') }}">
        @error('specialization')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    @if(!isset($teacher))
        <div class="mb-3">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password *</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
    @else
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        @if($errors->has('password'))
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        @endif
    @endif

    <div class="d-flex gap-2 justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">{{ isset($teacher) ? 'Update Teacher' : 'Add Teacher' }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
