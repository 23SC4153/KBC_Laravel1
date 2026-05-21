<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - KBC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold: #b8860b;
            --gold-2: #d4a017;
            --gold-dim: rgba(184,134,11,0.07);
            --gold-edge: rgba(184,134,11,0.22);
            --gold-mid: rgba(184,134,11,0.15);
            --red: #c0392b;
            --red-dim: rgba(192,57,43,0.07);
            --red-edge: rgba(192,57,43,0.20);
            --green: #27ae60;
            --bg-body: #fdfaf4;
            --bg-card: #ffffff;
            --bg-card-alt: #fef9f0;
            --tx-primary: #2a1a0a;
            --tx-secondary: #6b4c2a;
            --tx-muted: #a07850;
            --border-mid: rgba(184,134,11,0.15);
            --border-gold: rgba(184,134,11,0.22);
            --shadow-card: 0 4px 24px rgba(184,134,11,0.08), 0 1px 4px rgba(0,0,0,0.05);
            --shadow-drop: 0 8px 32px rgba(184,134,11,0.12);
            --font-display: 'Calibri', 'Segoe UI', sans-serif;
            --font-body: 'Calibri', 'Segoe UI', sans-serif;
        }

        html, body {
            height: 100%;
            width: 100%;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            color: var(--tx-secondary);
            background-image:
                radial-gradient(ellipse 60% 80% at 5% 0%, rgba(184,134,11,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 55% 70% at 95% 100%, rgba(192,57,43,0.06) 0%, transparent 60%);
            background-attachment: fixed;
        }

        body::before {
            content: '';
            position: fixed;
            top: -60px;
            left: -80px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(184,134,11,0.12) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -70px;
            right: -80px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(192,57,43,0.10) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .password-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 550px;
        }

        .password-card {
            background: var(--bg-card);
            border-radius: 18px;
            border: 1px solid var(--border-gold);
            box-shadow: var(--shadow-card);
            padding: 46px 40px;
            animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .password-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--gold) 25%, var(--gold-2) 50%, var(--red) 78%, transparent 100%);
        }

        .password-card::after {
            content: '';
            position: absolute;
            top: -70px;
            left: -70px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184,134,11,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            animation: slideDown 0.4s ease;
            border-left: 4px solid;
            background: var(--bg-card-alt);
            color: var(--tx-secondary);
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

        .alert-success {
            border-left-color: var(--green);
            background: rgba(39, 174, 96, 0.08);
            color: #1e8449;
        }

        .alert-error {
            border-left-color: var(--red);
            background: rgba(192, 57, 43, 0.08);
            color: #a93226;
        }

        .alert i {
            margin-right: 8px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--tx-primary);
            margin-bottom: 8px;
            font-family: var(--font-display);
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: var(--tx-muted);
            margin: 0;
        }

        .user-info-card {
            background: var(--bg-card-alt);
            border: 1px solid var(--border-mid);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 28px;
        }

        .user-info-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }

        .user-info-item {
            display: flex;
            flex-direction: column;
        }

        .user-info-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--tx-secondary);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-info-label i {
            color: var(--gold);
        }

        .user-info-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--tx-primary);
        }

        .password-form {
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

        .form-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--tx-primary);
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
            padding: 12px 44px 12px 44px;
            border: 1.5px solid var(--border-mid);
            border-radius: 10px;
            font-size: 0.95rem;
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
            border-width: 1.5px;
            background: rgba(192, 57, 43, 0.08);
        }

        .form-input.is-invalid:focus {
            background: rgba(192, 57, 43, 0.12);
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.1);
        }

        .toggle-password-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--tx-muted);
            cursor: pointer;
            font-size: 0.95rem;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
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
            font-size: 0.85rem;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .help-text {
            font-size: 0.85rem;
            color: var(--tx-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
        }

        .strength-weak { color: var(--red); font-weight: 600; }
        .strength-medium { color: #d97706; font-weight: 600; }
        .strength-strong { color: var(--green); font-weight: 600; }

        .btn-submit {
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-2) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
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

        @media (max-width: 768px) {
            .password-card {
                padding: 32px 24px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .form-input {
                padding: 11px 40px 11px 44px;
                font-size: 0.9rem;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="password-wrapper">
        <div class="password-card">
            <h1 class="page-title">Update Password</h1>
            <p class="page-subtitle">Secure your teacher account with a new password</p>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin: 8px 0 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- User Info --}}
            <div class="user-info-card">
                <div class="user-info-row">
                    <div class="user-info-item">
                        <span class="user-info-label">
                            <i class="fas fa-user"></i> Name
                        </span>
                        <span class="user-info-value">{{ $user->teacher->fname }} {{ $user->teacher->lname }}</span>
                    </div>
                    <div class="user-info-item">
                        <span class="user-info-label">
                            <i class="fas fa-envelope"></i> Email
                        </span>
                        <span class="user-info-value">{{ $user->email }}</span>
                    </div>
                    <div class="user-info-item">
                        <span class="user-info-label">
                            <i class="fas fa-user-tag"></i> Role
                        </span>
                        <span class="user-info-value">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>

            {{-- Password Form --}}
            <form action="{{ route('user.changePassword') }}" method="POST" id="passwordForm" class="password-form">
                @csrf
                @method('PUT')

                {{-- Current Password --}}
                <div class="form-group">
                    <label for="current_password" class="form-label">
                        <span class="label-text">Current Password</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="form-input @error('current_password') is-invalid @enderror"
                            placeholder="Enter your current password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('current_password')" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="error-text">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">
                        <span class="label-text">New Password</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Enter your new password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('password')" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-text">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <span class="label-text">Confirm New Password</span>
                        <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-check-circle"></i>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input @error('password_confirmation') is-invalid @enderror"
                            placeholder="Confirm your new password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password-btn" onclick="togglePassword('password_confirmation')" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="error-text">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </span>
                    @enderror
                    <span class="help-text" id="password-match-text"></span>
                </div>

                {{-- Actions --}}
                <div style="display: flex; gap: 12px; margin-top: 16px;">
                    <button type="submit" class="btn-submit">
                        <span class="btn-text">Update Password</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }

        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        const matchText = document.getElementById('password-match-text');

        function checkPasswordMatch() {
            if (confirmField.value && passwordField.value !== confirmField.value) {
                matchText.innerHTML = '<i class="fas fa-times-circle"></i> <span style="color: var(--red); font-weight: 600;">Passwords do not match</span>';
            } else if (confirmField.value === passwordField.value && passwordField.value) {
                matchText.innerHTML = '<i class="fas fa-check-circle"></i> <span style="color: var(--green); font-weight: 600;">Passwords match</span>';
            } else {
                matchText.innerHTML = '';
            }
        }

        passwordField?.addEventListener('input', checkPasswordMatch);
        confirmField?.addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>
