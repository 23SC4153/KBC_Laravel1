@extends('Student.Student.MainLayout')

@section('page_title', 'Student Dashboard')

@section('title')
    <h1>
        <span class="divine">Student</span> <span class="demon">Command Deck</span>
    </h1>
    <div class="hero-divider">
        <span>{{ optional($user->student->degree)->DegreeCode ?? 'N/A' }} - Focused Workspace</span>
    </div>
@endsection

@section('subtitle', 'A cleaner and calmer dashboard built for daily student flow.')

@push('styles')
<style>
    .studdash-shell {
        position: relative;
        display: grid;
        gap: 18px;
        isolation: isolate;
        width: 100%;
    }

    .studdash-frame {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-drop);
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(255, 249, 237, 0.98) 52%, rgba(255, 244, 240, 0.96));
        padding: 24px;
    }

    .studdash-frame::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            linear-gradient(rgba(184, 134, 11, 0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(184, 134, 11, 0.045) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: linear-gradient(135deg, rgba(0, 0, 0, 0.55), transparent 78%);
    }

    .studdash-shell::before,
    .studdash-shell::after {
        content: '';
        position: absolute;
        pointer-events: none;
        z-index: -1;
    }

    .studdash-shell::before {
        width: 280px;
        height: 280px;
        top: -70px;
        left: -70px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(184, 134, 11, 0.16) 0%, transparent 70%);
    }

    .studdash-shell::after {
        width: 240px;
        height: 240px;
        right: -60px;
        bottom: 40px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(192, 57, 43, 0.12) 0%, transparent 70%);
    }

    .studdash-spotlight {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 18px;
        padding: 24px 26px;
        border-radius: 18px;
        border: 1px solid var(--border-gold);
        box-shadow: var(--shadow-card);
        background:
            linear-gradient(130deg, rgba(255, 255, 255, 0.92), rgba(255, 248, 234, 0.97) 48%, rgba(255, 242, 237, 0.95));
    }

    .studdash-spotlight::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image:
            linear-gradient(rgba(184, 134, 11, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(184, 134, 11, 0.05) 1px, transparent 1px);
        background-size: 34px 34px;
        mask-image: linear-gradient(120deg, rgba(0, 0, 0, 0.75), transparent 80%);
    }

    .studdash-kicker {
        margin: 0 0 8px;
        font-family: var(--font-display);
        font-size: 11px;
        letter-spacing: 1.7px;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--gold);
    }

    .studdash-headline {
        margin: 0;
        font-family: var(--font-display);
        font-size: clamp(22px, 2.8vw, 34px);
        line-height: 1.1;
        color: var(--tx-primary);
    }

    .studdash-copy {
        margin: 8px 0 0;
        max-width: 560px;
        font-size: 18px;
        line-height: 1.6;
        color: var(--tx-secondary);
    }

    .studdash-chipboard {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-content: flex-start;
        max-width: 360px;
    }

    .studdash-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 999px;
        font-family: var(--font-display);
        font-size: 12px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        border: 1px solid var(--border-mid);
        background: #fff;
        color: var(--tx-secondary);
        white-space: nowrap;
    }

    .studdash-chip i {
        font-size: 12px;
    }

    .studdash-chip.is-good {
        background: rgba(16, 185, 129, 0.12);
        border-color: rgba(16, 185, 129, 0.35);
        color: #0f766e;
    }

    .studdash-chip.is-bad {
        background: rgba(192, 57, 43, 0.12);
        border-color: rgba(192, 57, 43, 0.35);
        color: #9f1239;
    }

    .studdash-chip.is-highlight {
        background: rgba(184, 134, 11, 0.14);
        border-color: rgba(184, 134, 11, 0.35);
        color: #8f6408;
    }

    .studdash-bento {
        display: grid;
        grid-template-columns: minmax(340px, 1.45fr) minmax(280px, 1fr);
        gap: 18px;
    }

    .studdash-side {
        display: grid;
        gap: 18px;
    }

    .studdash-panel {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        border: 1px solid var(--border-gold);
        box-shadow: none;
        background: var(--bg-card);
        padding: 22px;
        animation: studdashRise .55s var(--ease) both;
    }

    .studdash-panel::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        background: linear-gradient(90deg, rgba(184, 134, 11, 0.9), rgba(212, 160, 23, 0.8), rgba(192, 57, 43, 0.55));
    }

    .studdash-panel:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card);
    }

    .studdash-profile {
        background: linear-gradient(145deg, rgba(184, 134, 11, 0.07), rgba(255, 255, 255, 1) 26%, rgba(255, 255, 255, 1));
    }

    .studdash-panel-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .studdash-avatar {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--gold), var(--red));
        box-shadow: 0 10px 20px rgba(184, 134, 11, 0.25);
    }

    .studdash-panel-kicker {
        margin: 0 0 2px;
        font-size: 12px;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        font-family: var(--font-display);
        color: var(--tx-muted);
    }

    .studdash-panel-title {
        margin: 0;
        font-size: 22px;
        line-height: 1.2;
        font-family: var(--font-display);
        color: var(--tx-primary);
    }

    .studdash-specs {
        display: grid;
        gap: 10px;
        margin: 0;
    }

    .studdash-specs > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 1px dashed rgba(184, 134, 11, 0.28);
    }

    .studdash-specs > div:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .studdash-specs dt {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: var(--tx-muted);
    }

    .studdash-specs dd {
        margin: 0;
        text-align: right;
        font-size: 16px;
        font-weight: 700;
        color: var(--tx-primary);
    }

    .studdash-meter-wrap {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--border-mid);
    }

    .studdash-meter-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .studdash-meter-label {
        font-family: var(--font-display);
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--tx-muted);
    }

    .studdash-meter-value {
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 700;
        color: var(--gold);
    }

    .studdash-meter {
        width: 100%;
        height: 8px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(184, 134, 11, 0.18);
    }

    .studdash-meter > span {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--gold), var(--gold-2), var(--red));
    }

    .studdash-security-core {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 72px;
        height: 72px;
        border-radius: 50%;
        margin: 0 auto 14px;
        color: var(--red);
        background: radial-gradient(circle, rgba(255, 255, 255, 1) 45%, rgba(192, 57, 43, 0.1));
        border: 2px solid rgba(192, 57, 43, 0.28);
        box-shadow: 0 0 0 10px rgba(192, 57, 43, 0.08);
        animation: studdashPulse 2.8s ease-in-out infinite;
    }

    .studdash-security-core i {
        font-size: 28px;
    }

    .studdash-actions {
        border-radius: 18px;
        border: 1px solid var(--border-gold);
        box-shadow: none;
        background: linear-gradient(140deg, rgba(255, 248, 232, 0.64), rgba(255, 255, 255, 1));
        padding: 22px;
        animation: studdashRise .55s var(--ease) .08s both;
    }

    .studdash-actions-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .studdash-actions-title {
        margin: 0;
        font-family: var(--font-display);
        color: var(--tx-primary);
        font-size: 20px;
    }

    .studdash-actions-sub {
        margin: 0;
        color: var(--tx-secondary);
        font-size: 16px;
    }

    .studdash-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .studdash-action {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 9px;
        align-items: flex-start;
        min-height: 130px;
        padding: 15px;
        border-radius: 14px;
        border: 1px solid var(--border-mid);
        background: #fff;
        text-decoration: none;
        transition: transform .22s var(--ease), box-shadow .22s var(--ease), border-color .22s;
    }

    .studdash-action::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold), var(--red), transparent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .25s var(--ease);
    }

    .studdash-action:hover {
        transform: translateY(-4px);
        border-color: var(--gold-edge);
        box-shadow: var(--shadow-drop);
    }

    .studdash-action:hover::after {
        transform: scaleX(1);
    }

    .studdash-action-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        background: var(--gold-dim);
        font-size: 18px;
    }

    .studdash-action-title {
        margin: 0;
        font-family: var(--font-display);
        font-size: 16px;
        color: var(--tx-primary);
        line-height: 1.2;
    }

    .studdash-action-text {
        margin: 0;
        font-size: 15px;
        line-height: 1.45;
        color: var(--tx-muted);
    }

    .studdash-signout {
        display: flex;
        justify-content: flex-end;
    }

    .studdash-signout-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        border: 1px solid rgba(192, 57, 43, 0.35);
        background: linear-gradient(135deg, rgba(192, 57, 43, 0.15), rgba(192, 57, 43, 0.24));
        color: #8a1f17;
        font-family: var(--font-display);
        font-size: 13px;
        letter-spacing: 1.1px;
        text-transform: uppercase;
        font-weight: 700;
        transition: transform .2s var(--ease), box-shadow .2s var(--ease), background .2s var(--ease);
        cursor: pointer;
    }

    .studdash-signout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(192, 57, 43, 0.2);
        background: linear-gradient(135deg, rgba(192, 57, 43, 0.2), rgba(192, 57, 43, 0.3));
    }

    @keyframes studdashPulse {
        from {
            box-shadow: 0 0 0 0 rgba(192, 57, 43, 0.18), 0 0 0 10px rgba(192, 57, 43, 0.08);
        }
        to {
            box-shadow: 0 0 0 10px rgba(192, 57, 43, 0), 0 0 0 10px rgba(192, 57, 43, 0.08);
        }
    }

    @keyframes studdashRise {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1024px) {
        .studdash-bento {
            grid-template-columns: 1fr;
        }

        .studdash-actions-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .studdash-frame {
            padding: 18px;
            border-radius: 20px;
        }

        .studdash-spotlight {
            padding: 20px;
        }

        .studdash-headline {
            font-size: 26px;
        }

        .studdash-copy {
            font-size: 16px;
        }

        .studdash-chipboard {
            justify-content: flex-start;
            max-width: none;
        }

        .studdash-actions-grid {
            grid-template-columns: 1fr;
        }

        .studdash-signout {
            justify-content: stretch;
        }

        .studdash-signout form,
        .studdash-signout-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .studdash-frame {
            padding: 14px;
        }

        .studdash-panel,
        .studdash-actions {
            padding: 18px;
        }

        .studdash-panel-title {
            font-size: 19px;
        }

        .studdash-specs dt,
        .studdash-specs dd {
            font-size: 14px;
        }

        .studdash-action {
            min-height: 118px;
        }
    }
</style>
@endpush

@section('content')
@php
    $student = $user->student;
    $degree = optional($student)->degree;

    $firstName = optional($student)->fname ?? '';
    $middleName = optional($student)->mname ?? '';
    $lastName = optional($student)->lname ?? '';
    $fullName = trim($firstName . ' ' . ($middleName !== '' ? $middleName . ' ' : '') . $lastName);

    $degreeCode = optional($degree)->DegreeCode ?? 'N/A';
    $degreeName = optional($degree)->DegreeName ?? 'No program assigned';
    $contact = optional($student)->contact ?: 'Not provided';
    $studentRecordId = optional($student)->id;

    $memberSince = optional($user->created_at)->format('M d, Y') ?? 'N/A';
    $enrolledAt = optional(optional($student)->created_at)->format('M d, Y') ?? 'N/A';

    $profileCompletion = 55;
    if (!empty($user->email)) {
        $profileCompletion += 15;
    }
    if (!empty(optional($student)->contact)) {
        $profileCompletion += 15;
    }
    if (!empty(optional($degree)->DegreeCode)) {
        $profileCompletion += 15;
    }

    $initials = strtoupper(substr($firstName ?: 'S', 0, 1) . substr($lastName ?: 'T', 0, 1));
    $profileRoute = $studentRecordId ? route('Student.show', $studentRecordId) : route('Student.index');
@endphp

<div class="studdash-shell">
    <div class="studdash-frame">
        <section class="studdash-spotlight">
            <div>
                <p class="studdash-kicker">Student Dashboard</p>
                <h2 class="studdash-headline">{{ $fullName !== '' ? $fullName : $user->username }}</h2>
                <p class="studdash-copy">{{ $welcomeMessage ?? 'Welcome, Student!' }}</p>
            </div>

            <div class="studdash-chipboard">
                <span class="studdash-chip {{ $user->is_active ? 'is-good' : 'is-bad' }}">
                    <i class="fas fa-circle-check"></i>
                    {{ $user->is_active ? 'Active Account' : 'Inactive Account' }}
                </span>
                <span class="studdash-chip is-highlight">
                    <i class="fas fa-user-shield"></i>
                    {{ ucfirst($user->role) }} Role
                </span>
                <span class="studdash-chip">
                    <i class="fas fa-book-open"></i>
                    {{ $degreeCode }} Program
                </span>
            </div>
        </section>

        <section class="studdash-bento">
            <article class="studdash-panel studdash-profile">
                <div class="studdash-panel-head">
                    <span class="studdash-avatar">{{ $initials }}</span>
                    <div>
                        <p class="studdash-panel-kicker">Identity</p>
                        <h3 class="studdash-panel-title">{{ $user->username }}</h3>
                    </div>
                </div>

                <dl class="studdash-specs">
                    <div>
                        <dt>Full Name</dt>
                        <dd>{{ $fullName !== '' ? $fullName : 'Not provided' }}</dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt>Contact</dt>
                        <dd>{{ $contact }}</dd>
                    </div>
                    <div>
                        <dt>Student ID</dt>
                        <dd>{{ $studentRecordId ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt>Member Since</dt>
                        <dd>{{ $memberSince }}</dd>
                    </div>
                </dl>
            </article>

            <div class="studdash-side">
                <article class="studdash-panel">
                    <p class="studdash-panel-kicker">Academic</p>
                    <h3 class="studdash-panel-title">{{ $degreeCode }}</h3>

                    <dl class="studdash-specs" style="margin-top: 12px;">
                        <div>
                            <dt>Program Name</dt>
                            <dd>{{ $degreeName }}</dd>
                        </div>
                        <div>
                            <dt>Enrolled</dt>
                            <dd>{{ $enrolledAt }}</dd>
                        </div>
                        <div>
                            <dt>Portal Type</dt>
                            <dd>Student Access</dd>
                        </div>
                    </dl>

                    <div class="studdash-meter-wrap">
                        <div class="studdash-meter-head">
                            <span class="studdash-meter-label">Profile Readiness</span>
                            <span class="studdash-meter-value">{{ $profileCompletion }}%</span>
                        </div>
                        <div class="studdash-meter">
                            <span style="width: {{ $profileCompletion }}%;"></span>
                        </div>
                    </div>
                </article>

                <article class="studdash-panel">
                    <div class="studdash-security-core">
                        <i class="fas fa-shield-heart"></i>
                    </div>

                    <p class="studdash-panel-kicker" style="text-align: center;">Security</p>
                    <h3 class="studdash-panel-title" style="text-align: center; margin-bottom: 12px;">Guarded Session</h3>

                    <dl class="studdash-specs">
                        <div>
                            <dt>Password State</dt>
                            <dd>Secured</dd>
                        </div>
                        <div>
                            <dt>Session</dt>
                            <dd>Live Now</dd>
                        </div>
                        <div>
                            <dt>Account Status</dt>
                            <dd>{{ $user->is_active ? 'Verified' : 'Needs Attention' }}</dd>
                        </div>
                    </dl>
                </article>
            </div>
        </section>

        <section class="studdash-actions">
            <div class="studdash-actions-head">
                <h2 class="studdash-actions-title">Quick Launch</h2>
                <p class="studdash-actions-sub">Jump directly to your most-used actions.</p>
            </div>

            <div class="studdash-actions-grid">
                <a href="{{ route('user.changePasswordForm') }}" class="studdash-action" aria-label="Change password">
                    <span class="studdash-action-icon"><i class="fas fa-key"></i></span>
                    <h3 class="studdash-action-title">Change Password</h3>
                    <p class="studdash-action-text">Refresh your credentials and keep your account safe.</p>
                </a>

                <a href="{{ $profileRoute }}" class="studdash-action" aria-label="Open my profile">
                    <span class="studdash-action-icon"><i class="fas fa-id-card"></i></span>
                    <h3 class="studdash-action-title">My Profile</h3>
                    <p class="studdash-action-text">Review your personal and academic details.</p>
                </a>

                <a href="{{ route('Student.index') }}" class="studdash-action" aria-label="Browse students">
                    <span class="studdash-action-icon"><i class="fas fa-users"></i></span>
                    <h3 class="studdash-action-title">Students Directory</h3>
                    <p class="studdash-action-text">Browse classmates and student records quickly.</p>
                </a>

                <a href="{{ route('Degree.index') }}" class="studdash-action" aria-label="Browse degree programs">
                    <span class="studdash-action-icon"><i class="fas fa-scroll"></i></span>
                    <h3 class="studdash-action-title">Degree Programs</h3>
                    <p class="studdash-action-text">Check available programs and degree information.</p>
                </a>
            </div>
        </section>

        <div class="studdash-signout">
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" class="studdash-signout-btn">
                    <i class="fas fa-right-from-bracket"></i>
                    Secure Logout
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
