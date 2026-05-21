@extends('Student.Student.MainLayout')
@section('title')
    <h1>Edit Student</h1>
@endsection
@section('subtitle')
    Update student information
@endsection
@section('content')
<div class="card" style="max-width: 600px; margin: 30px auto;">
    <h3 style="padding: 20px; border-bottom: 1px solid var(--border-gold); color: var(--tx-primary);">Edit Student</h3>
    <div style="padding: 20px;">
        <form action="{{ route('Student.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">First Name *</label>
                <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname', $student->fname) }}" required>
                @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname', $student->mname) }}">
                @error('mname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name *</label>
                <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname', $student->lname) }}" required>
                @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Username *</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $student->userAccount->username ?? '') }}" required>
                @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contact (11 digits) *</label>
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $student->contact) }}" placeholder="09xxxxxxxxx" required>
                @error('contact')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            @if(session('role') === 'admin')
                <div class="mb-3">
                    <label class="form-label">Degree *</label>
                    <div class="position-relative">
                        <select name="degree_id" class="form-control @error('degree_id') is-invalid @enderror" required style="appearance: none; background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e\"); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem;">
                            @foreach($degrees as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id', $student->degree_id) == $degree->id ? 'selected' : '' }}>{{ $degree->DegreeCode }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('degree_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">Update Student</button>
                <a href="{{ route('Student.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
