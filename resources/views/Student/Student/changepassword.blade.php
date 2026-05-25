@extends('Student.Student.MainLayout')
@section('title')
    <h1>Change Password</h1>
@endsection

@section('content')
    <div class="card text-start">
        <div class="card-ember"></div>

        <h2>Change Student Password</h2>
        <p class="mb-4">Enter a new password for {{ $student->fname }} {{ $student->lname }}.</p>

        @if ($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <strong>Please review the following:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('Student.updatePassword', $student->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-12">
                    <div class="border rounded-3 p-3" style="background: rgba(184,134,11,0.03); border-color: rgba(184,134,11,0.18) !important;">
                        <label class="form-label mb-1">Student</label>
                        <div class="fw-semibold">
                            {{ $student->fname }} {{ $student->mname }} {{ $student->lname }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="border rounded-3 p-3" style="background: rgba(72,199,142,0.03); border-color: rgba(72,199,142,0.18) !important;">
                        <label class="form-label mb-1">Username</label>
                        <div class="fw-semibold">
                            {{ optional($student->userAccount)->username ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                    <div class="position-relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            autocomplete="new-password"
                            placeholder="Minimum 8 characters"
                            required
                        >
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword('password')" style="border: none; background: none; color: var(--tx-secondary);">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <div class="position-relative">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            autocomplete="new-password"
                            placeholder="Re-enter password"
                            required
                        >
                        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword('password_confirmation')" style="border: none; background: none; color: var(--tx-secondary);">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>

            <div class="d-flex flex-wrap gap-2 justify-content-start">
                <button type="submit" class="btn btn-primary">Change Password</button>
                <a href="{{ route('Student.show', $student->id) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
@endsection
