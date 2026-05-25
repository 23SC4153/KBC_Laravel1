<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Management') | KBC Laravel</title>

    {{-- ── Bootstrap ── --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ── Font Awesome ── --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- ── Per-page extra styles ── --}}
    @stack('styles')

    <style>
        /* ============================================================
           RESET
        ============================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ============================================================
           DESIGN TOKENS
        ============================================================ */
        :root {
            /* Divine (Gold) */
            --gold:           #b8860b;
            --gold-2:         #d4a017;
            --gold-3:         #f0c040;
            --gold-glow:      rgba(184,134,11,0.25);
            --gold-dim:       rgba(184,134,11,0.07);
            --gold-edge:      rgba(184,134,11,0.28);
            --gold-mid:       rgba(184,134,11,0.15);

            /* Infernal (Red) */
            --red:            #c0392b;
            --red-2:          #e05040;
            --red-glow:       rgba(192,57,43,0.20);
            --red-dim:        rgba(192,57,43,0.07);
            --red-edge:       rgba(192,57,43,0.25);

            /* Backgrounds */
            --bg-body:        #fdfaf4;
            --bg-card:        #ffffff;
            --bg-card-alt:    #fef9f0;
            --bg-nav:         rgba(255,252,244,0.97);
            --bg-sidebar:     rgba(255,250,240,0.98);

            /* Borders */
            --border-mid:     rgba(184,134,11,0.15);
            --border-gold:    rgba(184,134,11,0.22);
            --border-red:     rgba(192,57,43,0.20);

            /* Text */
            --tx-primary:     #2a1a0a;
            --tx-secondary:   #6b4c2a;
            --tx-muted:       #a07850;
            --tx-gold:        #b8860b;
            --tx-red:         #c0392b;

            /* Typography */
            --font-display:   'Calibri', 'Segoe UI', sans-serif;
            --font-body:      'Calibri', 'Segoe UI', sans-serif;
            --font-serif:     'Calibri', 'Segoe UI', sans-serif;

            /* Spacing / Shape */
            --radius-xs:  4px;
            --radius-sm:  6px;
            --radius-md:  12px;
            --radius-lg:  18px;
            --radius-xl:  26px;
            --nav-h:      68px;
            --sidebar-w:  240px;

            /* Shadows */
            --shadow-card:  0 4px 24px rgba(184,134,11,0.08), 0 1px 4px rgba(0,0,0,0.05);
            --shadow-nav:   0 2px 20px rgba(184,134,11,0.10);
            --shadow-drop:  0 8px 32px rgba(184,134,11,0.12);

            /* Easing */
            --ease:         cubic-bezier(0.16, 1, 0.3, 1);
            --ease-out:     cubic-bezier(0.0, 0, 0.2, 1);
        }

        /* ============================================================
           BASE
        ============================================================ */
        html { scroll-behavior: smooth; font-size: 16px; }

        body {
            font-family: var(--font-body);
            background: var(--bg-body);
            color: var(--tx-secondary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: var(--nav-h);          /* space for fixed footer */
            background-image:
                radial-gradient(ellipse 60% 80% at 5%   0%,   rgba(184,134,11,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 55% 70% at 95% 100%,  rgba(192,57,43,0.06) 0%, transparent 60%);
            background-attachment: fixed;
        }

        /* ============================================================
           ROSE PETALS — ambient animation
        ============================================================ */
        .rose-petals {
            position: fixed; inset: 0;
            pointer-events: none; overflow: hidden;
            z-index: 0;
        }

        .rose-petal {
            position: absolute;
            top: -14vh;
            width: 13px; height: 17px;
            opacity: .58;
            border-radius: 70% 45% 70% 45%;
            background: radial-gradient(circle at 35% 30%, #ffd8d2 0%, #f08e82 38%, #cc4b44 100%);
            box-shadow: 0 0 6px rgba(192,57,43,0.15);
            animation: petal-fall linear infinite;
        }
        .rose-petal:nth-child(odd) {
            border-radius: 45% 70% 45% 70%;
            background: radial-gradient(circle at 35% 30%, #ffd0ca 0%, #ea786d 40%, #b63d37 100%);
        }

        .rose-petal:nth-child(1)  { left:4%;  animation-duration:12s; animation-delay:-4s; }
        .rose-petal:nth-child(2)  { left:12%; animation-duration:14s; animation-delay:-9s; }
        .rose-petal:nth-child(3)  { left:20%; animation-duration:11s; animation-delay:-6s; }
        .rose-petal:nth-child(4)  { left:28%; animation-duration:16s; animation-delay:-12s;}
        .rose-petal:nth-child(5)  { left:36%; animation-duration:13s; animation-delay:-7s; }
        .rose-petal:nth-child(6)  { left:45%; animation-duration:10s; animation-delay:-2s; }
        .rose-petal:nth-child(7)  { left:54%; animation-duration:15s; animation-delay:-10s;}
        .rose-petal:nth-child(8)  { left:63%; animation-duration:12s; animation-delay:-5s; }
        .rose-petal:nth-child(9)  { left:72%; animation-duration:17s; animation-delay:-13s;}
        .rose-petal:nth-child(10) { left:81%; animation-duration:11s; animation-delay:-8s; }
        .rose-petal:nth-child(11) { left:89%; animation-duration:14s; animation-delay:-3s; }
        .rose-petal:nth-child(12) { left:96%; animation-duration:13s; animation-delay:-11s;}

        @keyframes petal-fall {
            0%   { transform: translate3d(0,   -10vh, 0) rotate(0deg)   scale(.9); opacity: 0; }
            10%  { opacity: .58; }
            50%  { transform: translate3d(20px, 50vh, 0) rotate(175deg) scale(1);  opacity: .65;}
            100% { transform: translate3d(-18px,110vh, 0) rotate(345deg) scale(.88);opacity: 0; }
        }

        /* ============================================================
           TOPBAR / NAVBAR
        ============================================================ */
        nav.main-nav {
            position: sticky; top: 0; z-index: 500;
            width: 100%; height: var(--nav-h);
            background: var(--bg-nav);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border-bottom: 1px solid var(--border-gold);
            box-shadow: var(--shadow-nav);
            display: flex; align-items: center;
            padding: 0 2.5rem; gap: 1.5rem;
            animation: slideDown .55s var(--ease) both;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to   { transform: translateY(0);     opacity: 1; }
        }

        /* Accent lines */
        nav.main-nav::before {
            content: '';
            position: absolute; left: 0; top: 10px; bottom: 10px; width: 3px;
            border-radius: 0 2px 2px 0;
            background: linear-gradient(180deg, transparent, var(--gold), transparent);
        }
        nav.main-nav::after {
            content: '';
            position: absolute; right: 0; top: 10px; bottom: 10px; width: 3px;
            border-radius: 2px 0 0 2px;
            background: linear-gradient(180deg, transparent, var(--red), transparent);
        }

        /* Brand */
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            font-family: var(--font-display);
            font-size: 1.1rem; font-weight: 900;
            letter-spacing: 3px; text-transform: uppercase;
            white-space: nowrap; text-decoration: none;
            color: var(--tx-primary);
        }
        .nav-brand .brand-kbc   { color: var(--gold); }
        .nav-brand .brand-sep   { color: var(--tx-muted); font-weight: 300; letter-spacing: 0; }
        .nav-brand .brand-laravel { color: var(--red); }

        .nav-brand .brand-emblem {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, var(--gold) 0% 50%, var(--red) 50% 100%);
            opacity: .85;
            flex-shrink: 0;
        }

        /* Nav links */
        ul.nav-links {
            list-style: none; display: flex; gap: 2px;
            margin: 0 0 0 auto; padding: 0; align-items: center;
        }

        ul.nav-links li a,
        ul.nav-links li button.nav-btn {
            display: inline-flex; align-items: center; gap: 6px;
            color: var(--tx-muted);
            font-family: var(--font-display);
            font-size: .62rem; font-weight: 600;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            text-decoration: none; letter-spacing: 1.4px;
            text-transform: uppercase;
            border: 1px solid transparent;
            background: none; cursor: pointer;
            transition: color .2s, background .2s, border-color .2s;
        }

        ul.nav-links li a:hover,
        ul.nav-links li button.nav-btn:hover {
            background: var(--gold-dim);
            color: var(--gold);
            border-color: var(--border-gold);
        }

        ul.nav-links li a.active {
            color: var(--gold);
            border-color: var(--gold-edge);
            background: var(--gold-dim);
        }

        ul.nav-links li a.nav-logout {
            color: var(--tx-red);
            border-color: var(--red-edge);
            background: var(--red-dim);
        }
        ul.nav-links li a.nav-logout:hover { background: rgba(192,57,43,0.14); }

        /* Mobile hamburger */
        .nav-toggle {
            display: none;
            flex-direction: column; gap: 5px;
            cursor: pointer; margin-left: auto;
            padding: 6px;
            background: none; border: none;
        }
        .nav-toggle span {
            display: block; width: 22px; height: 2px;
            background: var(--gold);
            border-radius: 2px;
            transition: transform .3s, opacity .3s;
        }

        /* ============================================================
           HERO STRIP
        ============================================================ */
        .hero-strip {
            width: 100%; position: relative; z-index: 1;
            background: linear-gradient(150deg, #fffbf0 0%, #fef5e4 40%, #fdf0ec 70%, #fdf8f5 100%);
            border-bottom: 1px solid var(--border-gold);
            padding: 1.35rem 2.5rem 1.45rem;
            overflow: hidden;
            animation: heroIn .65s var(--ease) .08s both;
            text-align: center;
        }

        @keyframes heroIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Crosshatch grid */
        .hero-strip::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(184,134,11,0.055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(184,134,11,0.055) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(135deg, rgba(0,0,0,.45) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-strip h1 {
            font-family: var(--font-display);
            font-size: clamp(1.35rem, 2vw, 1.95rem);
            font-weight: 900; letter-spacing: 1px;
            color: var(--tx-primary);
            position: relative; z-index: 1;
        }
        .hero-strip h1 .divine { color: var(--gold); }
        .hero-strip h1 .demon  { color: var(--red);  }

        /* ============================================================
           FLASH MESSAGES — displayed after hero / before content
        ============================================================ */
        .flash-wrapper {
            width: 100%; max-width: 1480px;
            padding: .75rem 1.5rem 0;
            margin: 0 auto;
            position: relative; z-index: 2;
        }

        .flash-wrapper .alert-success {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 1.05rem 1.25rem;
            margin-bottom: 1.25rem;
            border-radius: 16px;
            border: 1px solid rgba(39,174,96,0.28);
            border-left-width: 6px;
            background:
                linear-gradient(135deg, rgba(39,174,96,0.14), rgba(255,255,255,0.98) 58%, rgba(39,174,96,0.08));
            color: #1e8449;
            box-shadow: 0 16px 36px rgba(39,174,96,0.14);
            font-size: 1.08rem;
            font-weight: 600;
            line-height: 1.45;
        }

        .flash-wrapper .alert-success::before {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            flex-shrink: 0;
            background: rgba(39,174,96,0.16);
            color: #14804b;
            font-size: 1.05rem;
            box-shadow: inset 0 0 0 1px rgba(39,174,96,0.18);
        }

        .flash-wrapper .alert-success .btn-close {
            margin-left: auto;
            opacity: 0.8;
            box-shadow: none;
            filter: none;
        }

        .flash-wrapper .alert-success .btn-close:hover {
            opacity: 1;
        }

        .flash-wrapper .alert-success .btn-close:focus {
            box-shadow: 0 0 0 3px rgba(39,174,96,0.16);
        }

        .flash-wrapper .alert-success strong {
            font-weight: 800;
        }

        /* ============================================================
           LAYOUT SHELL  (content + optional sidebar)
        ============================================================ */
        .layout-shell {
            flex: 1;
            display: flex;
            width: 100%; max-width: 1480px;
            margin: -2rem auto 2rem;
            padding: 0 1.75rem;
            gap: 1.5rem;
            position: relative; z-index: 1;
            align-items: flex-start;
            animation: contentUp .6s var(--ease) .2s both;
        }

        @keyframes contentUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        main.content {
            flex: 1;
            min-width: 0;                          /* prevents flex overflow */
            width: 100%;
        }

        /* Optional sidebar (extend via @yield('sidebar')) */
        aside.sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* ============================================================
           CARD
        ============================================================ */
        .card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-gold);
            box-shadow: var(--shadow-card);
            padding: 2rem 2.5rem;
            margin-bottom: 1.5rem;
            position: relative; overflow: hidden;
            text-align: left;
        }

        /* Gradient top bar */
        .card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg,
                transparent 0%, var(--gold) 25%,
                var(--gold-2) 50%, var(--red) 78%, transparent 100%);
        }

        /* Ambient gold corner */
        .card::after {
            content: '';
            position: absolute; top: -60px; left: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(184,134,11,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Ambient red corner */
        .card .card-ember {
            position: absolute; bottom: -60px; right: -60px;
            width: 180px; height: 180px; border-radius: 50%;
            background: radial-gradient(circle, rgba(192,57,43,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Card variants */
        .card-flat {
            box-shadow: none;
            border-color: var(--border-mid);
        }
        .card-danger::before {
            background: linear-gradient(90deg, transparent, var(--red) 50%, transparent);
        }

        /* ============================================================
           TYPOGRAPHY
        ============================================================ */
        h1,h2,h3,h4 { font-family: var(--font-display); color: var(--tx-primary); line-height: 1.3; }

        h2 {
            font-size: 1.05rem; font-weight: 700;
            letter-spacing: 1.8px; text-transform: uppercase;
            margin-bottom: 1.2rem; color: var(--gold);
            display: flex; align-items: center; gap: 10px;
        }
        h2::before {
            content: '';
            display: inline-block; width: 3px; height: 16px;
            border-radius: 2px; flex-shrink: 0;
            background: linear-gradient(180deg, var(--gold), var(--red));
        }

        h3 { font-size: .92rem; letter-spacing: 1px; text-transform: uppercase; }

        p { font-family: var(--font-body); font-size: 1.12rem; line-height: 1.85; color: var(--tx-muted); }

        a { text-decoration: none; color: var(--gold); transition: color .2s; }
        a:hover { color: var(--gold-2); }

        /* ============================================================
           TABLES
        ============================================================ */
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%; border-collapse: collapse;
            font-size: 1.02rem; border-radius: var(--radius-md); overflow: hidden;
        }

        table thead {
            background: linear-gradient(90deg, rgba(184,134,11,0.07), rgba(192,57,43,0.04));
        }
        table thead th {
            padding: 14px 18px; text-align: left;
            font-family: var(--font-display);
            font-weight: 600; letter-spacing: 1.4px;
            font-size: .7rem; text-transform: uppercase;
            color: var(--gold);
            border-bottom: 1px solid rgba(184,134,11,0.18);
        }

        table tbody tr {
            background: transparent;
            border-bottom: 1px solid rgba(184,134,11,0.08);
            transition: background .15s, transform .15s;
        }
        table tbody tr:nth-child(even) { background: rgba(184,134,11,0.025); }
        table tbody tr:last-child { border-bottom: none; }
        table tbody tr:hover {
            background: rgba(184,134,11,0.06);
            transform: translateX(3px);
        }

        table td {
            padding: 12px 18px;
            color: var(--tx-secondary);
            font-family: var(--font-body); font-size: 1.06rem;
        }
        table td:first-child { font-weight: 600; color: var(--tx-primary); }

        /* Bootstrap table override */
        .table > :not(caption) > * > * {
            background-color: transparent;
            color: var(--tx-secondary);
            border-color: var(--border-mid);
        }

        /* ============================================================
           TABLE ACTIONS
        ============================================================ */
        .table-actions { display: flex; gap: .35rem; flex-wrap: wrap; align-items: center; }

        .table-action {
            display: inline-flex; align-items: center; gap: .28rem;
            padding: .22rem .7rem;
            border-radius: 999px;
            font-family: var(--font-display);
            font-size: .66rem; font-weight: 600;
            letter-spacing: .7px; text-transform: uppercase;
            text-decoration: none;
            border: 1px solid rgba(184,134,11,0.25);
            color: var(--gold);
            background: rgba(184,134,11,0.07);
            transition: transform .12s, background .15s, color .15s;
            cursor: pointer;
        }
        .table-action:hover {
            transform: translateY(-1px);
            background: rgba(184,134,11,0.16);
            color: var(--gold-2);
        }
        .table-action.delete {
            border-color: rgba(192,57,43,0.28);
            color: var(--red); background: rgba(192,57,43,0.06);
        }
        .table-action.delete:hover { background: rgba(192,57,43,0.15); }

        /* ============================================================
           BADGES
        ============================================================ */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 12px; border-radius: 100px;
            font-family: var(--font-display);
            font-size: .64rem; font-weight: 600;
            letter-spacing: .9px; text-transform: uppercase;
            background: rgba(184,134,11,0.10);
            color: var(--gold); border: 1px solid rgba(184,134,11,0.28);
        }
        .badge::before {
            content: ''; width: 4px; height: 4px;
            border-radius: 50%; background: var(--gold); flex-shrink: 0;
        }
        .badge-red {
            background: rgba(192,57,43,0.08);
            color: var(--red); border-color: rgba(192,57,43,0.25);
        }
        .badge-red::before { background: var(--red); }

        .badge-success {
            background: rgba(39,174,96,0.08);
            color: #27ae60; border-color: rgba(39,174,96,0.25);
        }
        .badge-success::before { background: #27ae60; }

        /* ============================================================
           STAT CARDS (for dashboards)
        ============================================================ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem; margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: var(--radius-md);
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-card);
            position: relative; overflow: hidden;
            text-align: center;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--red));
        }
        .stat-card .stat-value {
            font-family: var(--font-display);
            font-size: 2.2rem; font-weight: 900;
            color: var(--gold); line-height: 1;
        }
        .stat-card .stat-label {
            font-family: var(--font-display);
            font-size: .6rem; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--tx-muted);
            margin-top: .4rem;
        }
        .stat-card.stat-red .stat-value { color: var(--red); }
        .stat-card.stat-red::before { background: linear-gradient(90deg, var(--red), var(--gold)); }

        /* ============================================================
           DIVIDER
        ============================================================ */
        hr {
            border: none; height: 1px;
            background: linear-gradient(90deg,
                transparent,
                rgba(184,134,11,0.3) 30%,
                rgba(192,57,43,0.18) 70%,
                transparent);
            margin: 1.5rem 0;
        }

        /* ============================================================
           ALERTS
        ============================================================ */
        .alert {
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
            font-size: 1.08rem;
            padding: .75rem 1.1rem;
            margin-bottom: 1rem;
            border: 1px solid;
        }
        .alert-success {
            background: rgba(184,134,11,0.08);
            border-color: rgba(184,134,11,0.28);
            color: var(--gold);
        }
        .alert-danger {
            background: rgba(192,57,43,0.08);
            border-color: rgba(192,57,43,0.28);
            color: var(--red);
        }
        .alert-info {
            background: rgba(41,128,185,0.07);
            border-color: rgba(41,128,185,0.22);
            color: #2980b9;
        }

        /* ============================================================
           FORM ELEMENTS
        ============================================================ */
        .form-control, .form-select, textarea.form-control {
            background-color: #fffdf8;
            border: 1px solid rgba(184,134,11,0.22);
            color: var(--tx-primary);
            border-radius: var(--radius-sm);
            font-family: var(--font-body); font-size: 1.1rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(184,134,11,0.12);
            color: var(--tx-primary); outline: none;
        }
        .form-label {
            font-family: var(--font-display);
            font-size: .72rem; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--tx-muted);
            margin-bottom: .4rem;
        }
        .form-text { font-family: var(--font-body); font-size: .96rem; color: var(--tx-muted); }
        .invalid-feedback { font-family: var(--font-body); font-size: .98rem; }

        /* ============================================================
           BUTTONS
        ============================================================ */
        .btn { font-family: var(--font-display); letter-spacing: 1.2px; text-transform: uppercase; font-size: .74rem; }

        .btn-primary {
            background: linear-gradient(135deg, rgba(184,134,11,0.14), rgba(192,57,43,0.09));
            border: 1px solid rgba(184,134,11,0.40);
            color: var(--gold);
            border-radius: var(--radius-sm); padding: .5rem 1.6rem;
            transition: background .2s, box-shadow .2s, transform .1s;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, rgba(184,134,11,0.26), rgba(192,57,43,0.18));
            border-color: var(--gold);
            box-shadow: 0 0 20px rgba(184,134,11,0.22);
            transform: translateY(-1px); color: var(--gold-2);
        }

        .btn-danger {
            background: rgba(192,57,43,0.08);
            border: 1px solid rgba(192,57,43,0.35);
            color: var(--red);
            border-radius: var(--radius-sm); padding: .5rem 1.6rem;
            transition: background .2s, transform .1s;
        }
        .btn-danger:hover { background: rgba(192,57,43,0.18); transform: translateY(-1px); color: var(--red); }

        .btn-outline-secondary {
            border-color: var(--border-gold); color: var(--tx-muted);
        }
        .btn-outline-secondary:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }

        /* ============================================================
           PAGINATION
        ============================================================ */
        .pagination .page-link {
            font-family: var(--font-display);
            font-size: .7rem; letter-spacing: 1px;
            color: var(--gold);
            background: var(--bg-card);
            border-color: var(--border-gold);
            padding: .4rem .85rem;
        }
        .pagination .page-link:hover { background: var(--gold-dim); color: var(--gold-2); border-color: var(--gold); }
        .pagination .active .page-link {
            background: rgba(184,134,11,0.15);
            border-color: var(--gold); color: var(--gold);
        }

        /* ============================================================
           FOOTER — fixed bottom bar
        ============================================================ */
        footer.main-footer {
            position: fixed; bottom: 0; left: 0; width: 100%;
            background: rgba(255,252,244,0.97);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid var(--border-gold);
            color: var(--tx-muted); text-align: center;
            padding: 11px 20px;
            font-family: var(--font-display);
            font-size: .58rem; letter-spacing: 2px; text-transform: uppercase;
            z-index: 500;
        }
        footer.main-footer .divine-f { color: var(--gold); }
        footer.main-footer .demon-f  { color: var(--red);  }

        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #f5ede0; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--gold), var(--red));
            border-radius: 4px;
        }

        /* ============================================================
           BREADCRUMB
        ============================================================ */
        .breadcrumb {
            font-family: var(--font-display);
            font-size: .7rem; letter-spacing: 1.2px; text-transform: uppercase;
            margin-bottom: 1rem;
            background: none; padding: 0;
        }
        .breadcrumb-item a { color: var(--gold); }
        .breadcrumb-item.active { color: var(--tx-muted); }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--tx-muted); }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 900px) {
            aside.sidebar { display: none; }    /* hide sidebar on tablet */
        }

        @media (max-width: 640px) {
            nav.main-nav { padding: 0 1rem; gap: .75rem; }
            .nav-brand    { font-size: .88rem; letter-spacing: 2px; }

            ul.nav-links  {
                display: none; flex-direction: column;
                position: absolute; top: var(--nav-h); left: 0; right: 0;
                background: var(--bg-nav);
                border-bottom: 1px solid var(--border-gold);
                padding: 1rem; gap: .5rem;
            }
            ul.nav-links.is-open { display: flex; }
            ul.nav-links li a { font-size: .68rem; padding: 9px 14px; }

            .nav-toggle   { display: flex; }

            .layout-shell { padding: 0 1rem; }
            .card         { padding: 1.25rem; }
            .hero-strip   { padding: 1.8rem 1rem 3.4rem; }

            .rose-petal:nth-child(n+9) { display: none; }

            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    {{-- ── Per-page inline styles slot ── --}}
    @yield('page_styles')
</head>
<body style="@if (request()->routeIs('login.index')) padding-bottom: 0; @else padding-bottom: var(--nav-h); @endif">

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  AMBIENT PETALS                                              --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    <div class="rose-petals" aria-hidden="true">
        @for ($i = 0; $i < 12; $i++)
            <span class="rose-petal"></span>
        @endfor
    </div>

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  NAVBAR                                                      --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    @if (!request()->routeIs('login.index'))
    @section('header')
    <nav class="main-nav" role="navigation" aria-label="Main navigation">

        {{-- Brand --}}
        <a href="{{ route('user.dashboard') }}" class="nav-brand" aria-label="KBC Laravel Home">
            <div class="brand-emblem" aria-hidden="true"></div>
            <span>
                <span class="brand-kbc">KBC</span><span class="brand-sep">·</span><span class="brand-laravel">Laravel</span>
            </span>
        </a>

        {{-- Mobile toggle --}}
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        {{-- Links --}}
        <ul class="nav-links" id="navLinks" role="menubar">
            @if(session('user_id'))
                <li role="none"><a href="{{ route('user.dashboard') }}"
                    class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-home fa-fw"></i> Home
                </a></li>
            @endif

            {{-- ── Admin-only navigation items ── --}}
            @if(session('role') === 'admin')
                <li role="none"><a href="{{ route('Student.index') }}"
                    class="{{ request()->routeIs('Student.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-user-graduate fa-fw"></i> Students
                </a></li>

                {{-- Enrollment is available per-student in the Students list. --}}

                <li role="none"><a href="{{ route('Subject.index') }}"
                    class="{{ request()->routeIs('Subject.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-book fa-fw"></i> Subjects
                </a></li>

                <li role="none"><a href="{{ route('Degree.index') }}"
                    class="{{ request()->routeIs('Degree.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-graduation-cap fa-fw"></i> Degrees
                </a></li>

                <li role="none"><a href="{{ route('Enrollment.index') }}"
                    class="{{ request()->routeIs('Enrollment.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-list fa-fw"></i> Enrollment
                </a></li>

                <li role="none"><a href="{{ route('Teacher.index') }}"
                    class="{{ request()->routeIs('Teacher.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-chalkboard-user fa-fw"></i> Teachers
                </a></li>

                <li role="none"><a href="{{ route('admin.user.index') }}"
                    class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-users fa-fw"></i> Users
                </a></li>
            @endif

            {{-- ── Auth section ── --}}
            @if(session('user_id'))

                <li role="none">
                    <a href="#" class="nav-logout" onclick="confirmLogout(event)" role="menuitem"
                       title="Logged in as {{ session('username') }}">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </a>
                </li>
            @else
                <li role="none"><a href="{{ route('login.index') }}"
                    class="{{ request()->routeIs('login.*') ? 'active' : '' }}"
                    role="menuitem">
                    <i class="fas fa-sign-in-alt fa-fw"></i> Login
                </a></li>
            @endif

            {{-- ── Extend nav items from child views ── --}}
            @yield('nav_items')
        </ul>
    </nav>
    @show
    @endif

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  HERO STRIP                                                  --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    @hasSection('title')
    <div class="hero-strip">
        @yield('title')
    </div>
    @endif

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  FLASH MESSAGES                                              --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    <div class="flash-wrapper" role="alert" aria-live="polite">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  LAYOUT SHELL  (main + optional sidebar)                    --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    <div class="layout-shell">

        {{-- MAIN content area --}}
        <main class="content" id="main-content" role="main">
            @yield('content')
        </main>

        {{-- SIDEBAR — child view can fill this via @section('sidebar') --}}
        @hasSection('sidebar')
            <aside class="sidebar" role="complementary" aria-label="Sidebar">
                @yield('sidebar')
            </aside>
        @endif

    </div>

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  FOOTER                                                      --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    @if (!request()->routeIs('login.index'))
    @section('footer')
    <footer class="main-footer" role="contentinfo">
        <span>&copy; {{ date('Y') }}&ensp;
            <span class="divine-f">KBC</span>&thinsp;<span class="demon-f">Laravel</span>
            &mdash; All rights reserved.
        </span>
        @yield('footer_extra')
    </footer>
    @show
    @endif

    {{-- ──────────────────────────────────────────────────────────── --}}
    {{--  SCRIPTS                                                     --}}
    {{-- ──────────────────────────────────────────────────────────── --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/ajax-modal.js') }}"></script>

    <script>
        /* ─── Mobile nav toggle ─── */
        const navToggle = document.getElementById('navToggle');
        const navLinks  = document.getElementById('navLinks');

        if (navToggle && navLinks) {
            navToggle.addEventListener('click', () => {
                const open = navLinks.classList.toggle('is-open');
                navToggle.setAttribute('aria-expanded', open);
            });

            /* Close on outside click */
            document.addEventListener('click', (e) => {
                if (!navToggle.contains(e.target) && !navLinks.contains(e.target)) {
                    navLinks.classList.remove('is-open');
                    navToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        /* ─── Logout confirmation ─── */
        function confirmLogout(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to logout?')) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("user.logout") }}';

            const csrf = document.createElement('input');
            csrf.type  = 'hidden';
            csrf.name  = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        }

        /* ─── Auto-dismiss flash alerts after 4 s ─── */
        document.querySelectorAll('.alert.fade.show').forEach(el => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                bsAlert?.close();
            }, 4000);
        });
    </script>

    {{-- ── Per-page scripts slot ── --}}
    @stack('scripts')

    {{-- ── AJAX Modal Container ── --}}
    <div id="ajaxModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajaxModalLabel">Title</h5>
                </div>
                <div class="modal-body" id="ajaxModalBody">
                    <!-- Content loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ajaxModalSubmit" style="display:none;">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
