@extends('Student.Student.MainLayout')

@section('page_title', 'Student Login')

@section('subtitle')
    Sign in to your student account
@endsection

@push('styles')
<style>
    .login-content-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
    }

    .login-form-card {
        width: 100%;
        max-width: 500px;
    }

    /* Alert Messages */
    .login-notice {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 24px;
        padding: 16px 18px;
        border-radius: 14px;
        border: 1px solid var(--border-mid);
        border-left-width: 4px;
        background: var(--bg-card-alt);
        box-shadow: 0 8px 24px rgba(184, 134, 11, 0.08);
        animation: slideDown 0.4s ease;
    }

    .login-notice.is-error {
        border-left-color: var(--red);
        background: rgba(192,57,43,0.06);
    }

    .login-notice.is-success {
        border-left-color: #27ae60;
        background: rgba(39,174,96,0.08);
    }

    .login-notice__body {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        flex: 1;
    }

    .login-notice__icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(255,255,255,0.72);
    }

    .login-notice.is-error .login-notice__icon { color: var(--red); }
    .login-notice.is-success .login-notice__icon { color: #1e8449; }

    .login-notice__content {
        min-width: 0;
    }

    .login-notice__title {
        margin: 0 0 4px;
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--tx-primary);
    }

    .login-notice__text,
    .login-notice__list {
        margin: 0;
        font-size: 1rem;
        line-height: 1.55;
        color: var(--tx-secondary);
    }

    .login-notice__list {
        padding-left: 18px;
    }

    .login-notice__close {
        border: none;
        background: rgba(255,255,255,0.7);
        color: var(--tx-muted);
        width: 34px;
        height: 34px;
        border-radius: 10px;
        cursor: pointer;
        flex-shrink: 0;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .login-notice__close:hover {
        transform: translateY(-1px);
        background: rgba(255,255,255,0.95);
        color: var(--tx-primary);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form */
    .login-form {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }

    .form-group.has-error {
        gap: 10px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--tx-primary);
    }

    .form-group.has-error .form-label {
        color: var(--red);
    }

    .label-text {
        flex: 1;
    }

    .label-required {
        color: var(--red);
        font-weight: 700;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-wrapper i {
        position: absolute;
        left: 14px;
        color: var(--gold);
        font-size: 0.95rem;
        pointer-events: none;
        top: 50%;
        transform: translateY(-50%);
    }

    .form-input {
        width: 100%;
        padding: 12px 14px 12px 44px;
        border: 1.5px solid var(--border-mid);
        border-radius: 10px;
        font-size: 1.06rem;
        font-family: inherit;
        background: var(--bg-card-alt);
        color: var(--tx-primary);
        transition: all 0.3s ease;
        outline: none;
        height: 44px;
        display: flex;
        align-items: center;
    }

    .form-input:focus {
        background: white;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
    }

    .form-input::placeholder {
        color: #9a7c53;
    }

    .form-input.is-invalid {
        border-color: var(--red);
        border-width: 2px;
        background: rgba(192,57,43,0.12);
    }

    .form-input.is-invalid:focus {
        background: rgba(192,57,43,0.15);
        box-shadow: 0 0 0 4px rgba(192,57,43,0.18);
    }

    .form-group.has-error .form-input.is-invalid {
        border-width: 2px;
        background: rgba(192,57,43,0.14);
    }

    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .password-wrapper .form-input {
        padding-right: 44px;
    }

    .toggle-password-btn {
        position: absolute;
        right: 8px;
        background: none;
        border: none;
        color: var(--tx-muted);
        cursor: pointer;
        font-size: 0.95rem;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.3s ease;
        border-radius: 6px;
        height: 44px;
        width: 44px;
        top: 0;
    }

    .toggle-password-btn:hover {
        color: var(--gold);
        background: rgba(184, 134, 11, 0.1);
    }

    .error-text {
        font-size: 0.96rem;
        color: var(--red);
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 8px;
        background: rgba(192,57,43,0.08);
        border: 1px solid rgba(192,57,43,0.22);
    }

    .error-text i {
        font-size: 0.88rem;
        flex-shrink: 0;
    }

    /* Checkbox */
    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 8px 0;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--gold);
        border: 1.5px solid var(--border-mid);
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .checkbox-input:hover {
        border-color: var(--gold);
    }

    .checkbox-input:checked {
        border-color: var(--gold);
    }

    .checkbox-label {
        font-size: 1rem;
        color: var(--tx-secondary);
        cursor: pointer;
        user-select: none;
        margin: 0;
    }

    /* Submit Button */
    .btn-submit {
        padding: 14px 24px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-2) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 8px;
        box-shadow: 0 4px 15px rgba(184, 134, 11, 0.22);
        position: relative;
        overflow: hidden;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(184, 134, 11, 0.3);
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-text {
        flex: 1;
    }

    /* Footer */
    .login-footer {
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid var(--border-mid);
        text-align: center;
    }

    .footer-text {
        font-size: 1rem;
        color: var(--tx-secondary);
        margin: 0;
    }

    .footer-link {
        color: var(--gold);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .footer-link:hover {
        color: var(--gold-2);
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-content-wrapper {
            padding: 30px 15px;
            min-height: auto;
        }

        .login-form-card {
            max-width: none;
        }

        .form-input {
            padding: 11px 12px 11px 40px;
            font-size: 0.9rem;
        }

        .btn-submit {
            padding: 12px 20px;
            font-size: 0.95rem;
        }

        .login-notice {
            padding: 14px;
            margin-bottom: 20px;
        }

        .login-notice__body {
            gap: 10px;
        }

        .login-footer {
            margin-top: 20px;
            padding-top: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-content-wrapper">
    <div class="card login-form-card text-start">
        @if (session('error'))
            <div class="login-notice is-error" role="alert" aria-live="polite">
                <div class="login-notice__body">
                    <div class="login-notice__icon" aria-hidden="true">
                        <i class="fas fa-circle-xmark"></i>
                    </div>
                    <div class="login-notice__content">
                        <div class="login-notice__title">Error</div>
                        <p class="login-notice__text">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="login-notice__close" aria-label="Dismiss notification" onclick="this.closest('.login-notice').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login.login') }}" class="login-form" novalidate>
            @csrf

            {{-- Username / Email Field --}}
            <div class="form-group @error('username') has-error @enderror">
                <label for="username" class="form-label">
                    <span class="label-text">Username or Email</span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input @error('username') is-invalid @enderror"
                        placeholder="Enter your username or email"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                    >
                </div>
                @error('username')
                    <span class="error-text">
                        <i class="fas fa-info-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="form-group @error('password') has-error @enderror">
                <label for="password" class="form-label">
                    <span class="label-text">Password</span>
                    <span class="label-required">*</span>
                </label>
                <div class="input-wrapper password-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password-btn" onclick="togglePassword()" title="Show/Hide Password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="error-text">
                        <i class="fas fa-info-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="form-checkbox">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember"
                    class="checkbox-input"
                >
                <label for="remember" class="checkbox-label">
                    Remember me for next time
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-submit">
                <span class="btn-text">Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        {{-- Footer Links --}}
        <div class="login-footer">
            <p class="footer-text">
                New student? 
                <a href="{{ route('Student.index') }}" class="footer-link">
                    Learn More
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-clear password on page load if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordFormGroup = passwordInput.closest('.form-group');
        
        // Clear password if validation error exists
        if (passwordFormGroup.classList.contains('has-error')) {
            passwordInput.value = '';
            passwordInput.focus();
        }
    });

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.querySelector('.toggle-password-btn');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
@endpush

@section('content')
<div class="card text-start">
            @if (session('error'))
                <div class="login-notice is-error" role="alert" aria-live="polite">
                    <div class="login-notice__body">
                        <div class="login-notice__icon" aria-hidden="true">
                            <i class="fas fa-circle-xmark"></i>
                        </div>
                        <div class="login-notice__content">
                            <div class="login-notice__title">Error</div>
                            <p class="login-notice__text">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" class="login-notice__close" aria-label="Dismiss notification" onclick="this.closest('.login-notice').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- Header --}}
            <div class="login-header">
                <div class="login-icon-wrapper">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your student account</p>
            </div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.login') }}" class="login-form" novalidate>
                @csrf

                {{-- Username / Email Field --}}
                <div class="form-group @error('username') has-error @enderror">
                    <label for="username" class="form-label">
                        <span class="label-text">Username or Email</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-input @error('username') is-invalid @enderror"
                            placeholder="Enter your username or email"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                        >
                    </div>
                    @error('username')
                        <span class="error-text">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div class="form-group @error('password') has-error @enderror">
                    <label for="password" class="form-label">
                        <span class="label-text">Password</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper password-wrapper">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password-btn" onclick="togglePassword()" title="Show/Hide Password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-text">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-checkbox">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="checkbox-input"
                    >
                    <label for="remember" class="checkbox-label">
                        Remember me for next time
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-submit">
                    <span class="btn-text">Sign In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            {{-- Footer Links --}}
            <div class="login-footer">
                <p class="footer-text">
                    New student? 
                    <a href="{{ route('Student.index') }}" class="footer-link">
                        Learn More
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
        // Auto-clear password on page load if there are validation errors
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordFormGroup = passwordInput.closest('.form-group');
            
            // Clear password if validation error exists
            if (passwordFormGroup.classList.contains('has-error')) {
                passwordInput.value = '';
                passwordInput.focus();
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-password-btn');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
