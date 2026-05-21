@extends('Student.Student.MainLayout')
@section('title')
    <h1>Add Teacher</h1>
@endsection
@section('subtitle')
    Create a new teacher account
@endsection
@section('content')
<div class="card" style="max-width: 600px; margin: 30px auto;">
    <h3 style="padding: 20px; border-bottom: 1px solid var(--border-gold); color: var(--tx-primary);">Add New Teacher</h3>
    <div style="padding: 20px;">
        <form action="{{ route('Teacher.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">First Name *</label>
                <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" required>
                @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname') }}">
                @error('mname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name *</label>
                <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}" required>
                @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Username *</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Contact (11 digits) *</label>
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" placeholder="09xxxxxxxxx" required>
                @error('contact')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization') }}">
                @error('specialization')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Add Teacher</button>
                <a href="{{ route('Teacher.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
