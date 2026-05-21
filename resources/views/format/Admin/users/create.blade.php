@extends('Student.Student.MainLayout')
@section('title')
    <h1>Create User</h1>
@endsection
@section('subtitle')
    Add a new user and assign role
@endsection
@push('styles')
<style>
    .form-group { margin-bottom:20px; }
    .form-label { font-family:var(--font-display); font-size:0.72rem; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); margin-bottom:8px; display:block; font-weight:600; }
    .form-control { background-color:#fffdf8; border:1px solid rgba(184,134,11,0.22); color:var(--tx-primary); border-radius:6px; font-family:var(--font-body); font-size:1rem; padding:10px 12px; transition:border-color 0.2s, box-shadow 0.2s; width:100%; }
    .form-control:focus { background-color:#ffffff; border-color:var(--gold); box-shadow:0 0 0 3px rgba(184,134,11,0.12); outline:none; }
    .form-select { background-color:#fffdf8; border:1px solid rgba(184,134,11,0.22); color:var(--tx-primary); border-radius:6px; font-family:var(--font-body); font-size:1rem; padding:10px 12px; transition:border-color 0.2s, box-shadow 0.2s; width:100%; cursor:pointer; }
    .form-select:focus { background-color:#ffffff; border-color:var(--gold); box-shadow:0 0 0 3px rgba(184,134,11,0.12); outline:none; }
    .form-check { display:flex; align-items:center; gap:8px; margin-bottom:16px; }
    .form-check-input { width:18px; height:18px; border:1px solid var(--border-mid); border-radius:4px; cursor:pointer; }
    .form-check-input:checked { background-color:var(--gold); border-color:var(--gold); }
    .form-check-label { cursor:pointer; margin:0; color:var(--tx-primary); font-weight:600; }
    .btn-submit { background:linear-gradient(135deg,#10b981 0%,#059669 100%); color:white; border:none; padding:11px 28px; border-radius:8px; font-weight:600; text-transform:uppercase; letter-spacing:1px; cursor:pointer; transition:transform 0.2s; }
    .btn-submit:hover { transform:translateY(-2px); }
    .btn-cancel { background:var(--bg-card-alt); color:var(--tx-primary); border:1px solid var(--border-mid); padding:11px 28px; border-radius:8px; font-weight:600; text-decoration:none; transition:background 0.2s; }
    .btn-cancel:hover { background:var(--gold-dim); }
    .form-actions { display:flex; gap:12px; margin-top:24px; }
    .invalid-feedback { font-family:var(--font-body); font-size:0.9rem; color:var(--red); margin-top:4px; display:block; }
</style>
@endpush
@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <form action="{{ route('admin.user.store') }}" method="POST" class="form-validate" novalidate>
            @csrf

            <div style="max-width:600px;">
                <!-- Username -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        class="form-control @error('username') is-invalid @enderror" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}" 
                        required 
                        minlength="3"
                        placeholder="Enter username"
                    >
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="Enter email address"
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        required 
                        minlength="6"
                        placeholder="Enter password (min 6 characters)"
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        minlength="6"
                        placeholder="Confirm password"
                    >
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select 
                        class="form-select @error('role') is-invalid @enderror" 
                        id="role" 
                        name="role" 
                        required
                    >
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small style="color:var(--tx-muted); margin-top:4px; display:block;">
                        • <strong>Admin:</strong> Full system access<br>
                        • <strong>Teacher:</strong> Can manage courses and assignments<br>
                        • <strong>Student:</strong> Access to student dashboard and courses
                    </small>
                </div>

                <!-- Active Status -->
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input" 
                        id="is_active" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_active">
                        Activate user immediately
                    </label>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Create User
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
