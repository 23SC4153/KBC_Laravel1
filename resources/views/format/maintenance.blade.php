<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Down for Maintenance - {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            :root {
                --divine-gold:    #b8860b;
                --divine-gold2:   #d4a017;
                --divine-glow:    rgba(184,134,11,0.25);
                --divine-dim:     rgba(184,134,11,0.07);
                --divine-edge:    rgba(184,134,11,0.28);
                --red:            #c0392b;
                --red-glow:       rgba(192,57,43,0.2);
                --red-dim:        rgba(192,57,43,0.07);

                --bg-body:        #fdfaf4;
                --bg-card:        #ffffff;

                --border-divine:  rgba(184,134,11,0.22);

                --text-primary:   #2a1a0a;
                --text-secondary: #6b4c2a;
                --text-muted:     #a07850;

                --radius-md:  12px;
                --radius-lg:  18px;

                --shadow-card: 0 4px 24px rgba(184,134,11,0.08), 0 1px 4px rgba(0,0,0,0.05);
                --ease: cubic-bezier(0.16, 1, 0.3, 1);
            }

            html { scroll-behavior: smooth; }

            body {
                font-family: Calibri, 'Segoe UI', sans-serif;
                background: var(--bg-body);
                color: var(--text-secondary);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                text-align: center;
                background-image:
                    radial-gradient(ellipse 55% 70% at 8% 0%,   rgba(184,134,11,0.08) 0%, transparent 55%),
                    radial-gradient(ellipse 50% 65% at 92% 100%, rgba(192,57,43,0.07) 0%, transparent 55%);
                background-attachment: fixed;
                position: relative;
            }

            /* =========================================================
               ROSE PETALS
            ========================================================= */
            .rose-petals {
                position: fixed;
                inset: 0;
                pointer-events: none;
                overflow: hidden;
                z-index: 0;
            }

            .rose-petal {
                position: absolute;
                top: -12vh;
                width: 14px;
                height: 18px;
                opacity: .62;
                border-radius: 70% 45% 70% 45%;
                background: radial-gradient(circle at 35% 30%, #ffd8d2 0%, #f08e82 38%, #cc4b44 100%);
                box-shadow: 0 0 6px rgba(192,57,43,0.18);
                animation: petal-fall linear infinite;
            }

            .rose-petal:nth-child(odd) {
                border-radius: 45% 70% 45% 70%;
                background: radial-gradient(circle at 35% 30%, #ffd0ca 0%, #ea786d 40%, #b63d37 100%);
            }

            .rose-petal:nth-child(1)  { left: 4%;  animation-duration: 12s; animation-delay: -4s; }
            .rose-petal:nth-child(2)  { left: 12%; animation-duration: 14s; animation-delay: -9s; }
            .rose-petal:nth-child(3)  { left: 20%; animation-duration: 11s; animation-delay: -6s; }
            .rose-petal:nth-child(4)  { left: 28%; animation-duration: 16s; animation-delay: -12s; }
            .rose-petal:nth-child(5)  { left: 36%; animation-duration: 13s; animation-delay: -7s; }
            .rose-petal:nth-child(6)  { left: 45%; animation-duration: 10s; animation-delay: -2s; }
            .rose-petal:nth-child(7)  { left: 54%; animation-duration: 15s; animation-delay: -10s; }
            .rose-petal:nth-child(8)  { left: 63%; animation-duration: 12s; animation-delay: -5s; }
            .rose-petal:nth-child(9)  { left: 72%; animation-duration: 17s; animation-delay: -13s; }
            .rose-petal:nth-child(10) { left: 81%; animation-duration: 11s; animation-delay: -8s; }
            .rose-petal:nth-child(11) { left: 89%; animation-duration: 14s; animation-delay: -3s; }
            .rose-petal:nth-child(12) { left: 96%; animation-duration: 13s; animation-delay: -11s; }

            @keyframes petal-fall {
                0% {
                    transform: translate3d(0, -10vh, 0) rotate(0deg) scale(.9);
                    opacity: 0;
                }
                12% {
                    opacity: .62;
                }
                50% {
                    transform: translate3d(20px, 48vh, 0) rotate(170deg) scale(1);
                    opacity: .7;
                }
                100% {
                    transform: translate3d(-18px, 108vh, 0) rotate(340deg) scale(.88);
                    opacity: 0;
                }
            }

            .card {
                background: var(--bg-card);
                border-radius: var(--radius-lg);
                border: 1px solid var(--border-divine);
                box-shadow: var(--shadow-card);
                padding: 2rem 2.5rem;
                position: relative;
                overflow: hidden;
                max-width: 600px;
                width: 100%;
                z-index: 1;
            }

            .card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 2px;
                background: linear-gradient(90deg,
                    transparent 0%,
                    var(--divine-gold) 20%,
                    #d4a017 50%,
                    var(--red) 80%,
                    transparent 100%
                );
            }

            .card::after {
                content: '';
                position: absolute;
                top: -60px; left: -60px;
                width: 200px; height: 200px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(184,134,11,0.05) 0%, transparent 70%);
                pointer-events: none;
            }

            .card .card-ember {
                position: absolute;
                bottom: -60px; right: -60px;
                width: 180px; height: 180px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(192,57,43,0.05) 0%, transparent 70%);
                pointer-events: none;
            }

            h1 {
                font-family: Calibri, 'Segoe UI', sans-serif;
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--divine-gold);
                margin-bottom: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 3px;
                position: relative;
                z-index: 1;
            }

            .subtitle {
                font-family: Calibri, 'Segoe UI', sans-serif;
                font-style: italic;
                font-size: 1.3rem;
                color: var(--text-secondary);
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 1;
            }

            .status {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                padding: 1rem;
                background: var(--divine-dim);
                border: 1px solid var(--divine-edge);
                border-radius: var(--radius-md);
                margin-top: 1.5rem;
                position: relative;
                z-index: 1;
            }

            .pulse-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: var(--divine-gold);
                animation: pulse 2s infinite;
                flex-shrink: 0;
            }

            .status-text {
                color: var(--text-primary);
                font-weight: 600;
                letter-spacing: 0.5px;
                font-size: 0.95rem;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.3; }
            }

            @media (max-width: 768px) {
                h1 { font-size: 2rem; letter-spacing: 2px; }
                .subtitle { font-size: 1.1rem; }
                .card { padding: 2rem; }
            }
        </style>
    </head>
    <body>
        <div class="rose-petals">
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
            <div class="rose-petal"></div>
        </div>

        <div class="card">
            <div class="card-ember"></div>
            <h1>Down for Maintenance</h1>
            <p class="subtitle">We'll be back soon</p>
            <div class="status">
                <div class="pulse-dot"></div>
                <span class="status-text">Systems Updating</span>
            </div>
        </div>
    </body>
</html>
