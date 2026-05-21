<form action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label class="form-label">Username *</label>
        <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="form-control @error('username') is-invalid @enderror" required>
        @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password {{ isset($user) ? '(leave blank to keep current)' : '*' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ isset($user) ? '' : 'required' }} {{ isset($user) ? 'placeholder="New password"' : 'placeholder="Password"' }}>
        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password {{ isset($user) ? '' : '*' }}</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
    </div>

    <div class="mb-3">
        <label class="form-label">Role *</label>
        <select name="role" class="form-control @error('role') is-invalid @enderror" required>
            <option value="">Select role</option>
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ old('role', $user->role ?? '') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
        @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>

    <div class="form-check mb-4">
        <input type="checkbox" id="is_active" name="is_active" value="1" class="form-check-input" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Activate user</label>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update User' : 'Create User' }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
