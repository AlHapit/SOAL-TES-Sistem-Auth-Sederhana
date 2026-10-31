<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#061936">
    <title>Login | Politeknik Mitra Industri</title>
    <style>
        :root {
            color-scheme: dark;
            --navy: #061936;
            --ink: #091f42;
            --blue: #1684df;
            --ice: #dff2ff;
            --line: #4fb1f7;
            --muted: #9db5ca;
            --danger: #ff8c8c;
            --panel: #0a274eeb;
        }

        * { box-sizing: border-box; }

        body {
            min-width: 320px;
            margin: 0;
            min-height: 100vh;
            color: #f8fcff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #061936;
        }

        .login-page {
            position: relative;
            isolation: isolate;
            display: grid;
            place-items: center;
            min-height: 100vh;
            overflow: hidden;
            padding: 32px 20px;
            background: linear-gradient(120deg, #041127dc, #0a3264db), url('{{ asset('assets/background/campus.png') }}') center / cover no-repeat;
        }

        .login-page::before {
            content: "";
            position: absolute;
            z-index: -1;
            inset: 0;
            opacity: .28;
            background-image: linear-gradient(#6bc4ff22 1px, transparent 1px), linear-gradient(90deg, #6bc4ff22 1px, transparent 1px);
            background-size: 30px 30px;
            mask-image: linear-gradient(to bottom, #0009, transparent);
        }

        .login-shell { width: min(1040px, 100%); }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 24px;
            text-align: left;
        }

        .brand img {
            width: 104px;
            height: 64px;
            object-fit: cover;
            object-position: center;
            border: 1px solid #74c8ff77;
            image-rendering: pixelated;
        }

        .brand-copy small,
        .eyebrow,
        .field label,
        .login-button {
            font-family: "Courier New", monospace;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .brand-copy small {
            color: #86cfff;
            font-size: .66rem;
        }

        .brand-copy strong {
            display: block;
            margin-top: 3px;
            font-size: clamp(.9rem, 2vw, 1.25rem);
            letter-spacing: .04em;
        }

        .login-grid {
            display: grid;
            grid-template-columns: minmax(270px, .95fr) minmax(310px, 1fr);
            border: 1px solid #7fd0ff80;
            box-shadow: 0 26px 80px #000a, inset 0 0 0 1px #ffffff0f;
            background: #071b39d9;
        }

        .character-panel {
            position: relative;
            display: grid;
            min-height: 530px;
            place-items: end center;
            overflow: hidden;
            padding: 38px 30px 0;
            background: linear-gradient(145deg, #0c3c70bb, #061a39f0);
            border-right: 1px solid #75caff77;
        }

        .character-panel::before {
            content: "";
            position: absolute;
            inset: 22px;
            border: 1px solid #73c6ff3d;
            clip-path: polygon(0 0, 86% 0, 100% 14%, 100% 100%, 14% 100%, 0 86%);
        }

        .character-panel::after {
            content: "";
            position: absolute;
            top: 40px;
            left: 42px;
            width: 42px;
            height: 42px;
            background: linear-gradient(90deg, transparent 42%, #9cddff88 42% 58%, transparent 58%), linear-gradient(transparent 42%, #9cddff88 42% 58%, transparent 58%);
            opacity: .75;
        }

        .character-caption {
            position: absolute;
            z-index: 1;
            top: 35px;
            left: 42px;
            color: #cceeff;
            font: 700 .68rem/1.6 "Courier New", monospace;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .status-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            margin-right: 7px;
            background: #79d7ff;
            box-shadow: 0 0 12px #79d7ff;
            animation: blink 2.3s steps(2) infinite;
        }

        .student {
            position: relative;
            z-index: 1;
            display: block;
            width: min(100%, 330px);
            max-height: 445px;
            object-fit: contain;
            object-position: bottom;
            image-rendering: pixelated;
            filter: drop-shadow(0 17px 17px #0009);
            transform-origin: center bottom;
            animation: idle 3.8s ease-in-out infinite;
        }

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(32px, 6vw, 70px);
            background: linear-gradient(160deg, #0d315edb, #071b39f2);
        }

        .eyebrow {
            margin: 0 0 10px;
            color: #83ccfa;
            font-size: .7rem;
            font-weight: 700;
        }

        h1 {
            margin: 0;
            font-size: clamp(1.85rem, 4vw, 2.5rem);
            letter-spacing: -.04em;
        }

        .intro {
            margin: 10px 0 30px;
            color: var(--muted);
            font-size: .94rem;
            line-height: 1.6;
        }

        .flash {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin: 0 0 20px;
            padding: 11px 12px;
            border-left: 3px solid #77d5ff;
            background: #0c497299;
            color: #e8f8ff;
            font-size: .85rem;
            line-height: 1.45;
            animation: notice 5s ease both;
        }

        .flash.error {
            border-color: var(--danger);
            background: #5b2030c9;
            color: #fff0f0;
        }

        .flash strong { font-size: 1rem; }

        form { display: grid; gap: 19px; }

        .field { display: grid; gap: 8px; }

        .field label {
            color: #ccecff;
            font-size: .71rem;
            font-weight: 700;
        }

        .field input {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid #78cfff80;
            outline: none;
            color: #f7fcff;
            background: #061a38bc;
            transition: border-color .16s, box-shadow .16s, background .16s;
        }

        .field input::placeholder { color: #7892ac; }

        .field input:focus {
            border-color: #a6e4ff;
            background: #09244ac9;
            box-shadow: 0 0 0 3px #47b6ff2e;
        }

        .field-error {
            margin: 0;
            color: #ffc3c3;
            font-size: .78rem;
        }

        .login-button {
            position: relative;
            min-height: 50px;
            margin-top: 6px;
            overflow: hidden;
            border: 1px solid #8cd9ff;
            color: #061936;
            font-weight: 800;
            background: #9bdcff;
            cursor: pointer;
            transition: transform .16s, background .16s, box-shadow .16s;
        }

        .login-button::after {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 70%;
            height: 100%;
            transform: skewX(-20deg);
            background: #fff8;
            transition: left .35s;
        }

        .login-button:hover,
        .login-button:focus-visible {
            background: #d4f1ff;
            box-shadow: 0 0 22px #61c8ff66;
            transform: translateY(-2px);
        }

        .login-button:hover::after { left: 140%; }

        .login-button:active { transform: translateY(0); }

        .form-footer { 
            margin: 24px 0 0;
            color: #91acc3;
            font-size: .75rem;
            line-height: 1.6;
        }

        .form-footer a {
            color: #81d0ff;
            text-decoration: none;
        }

        .form-footer a:hover { text-decoration: underline; }

        .form-footer span { color: #81d0ff; }

        .is-error { animation: shake .46s cubic-bezier(.36,.07,.19,.97) both; }

        .character-panel.is-error .student { animation: error-reaction .42s ease-in-out 2; }

        @keyframes idle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes blink {
            50% { opacity: .25; }
        }

        @keyframes shake {
            15%, 45%, 75% { transform: translateX(-7px); }
            30%, 60%, 90% { transform: translateX(7px); }
        }

        @keyframes error-reaction {
            0%, 100% { transform: translateX(0) rotate(0); }
            25% { transform: translateX(-9px) rotate(-1deg); }
            75% { transform: translateX(9px) rotate(1deg); }
        }

        @keyframes notice {
            0%, 90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-4px); }
        }

        @media (max-width: 700px) {
            .login-page { padding: 22px 14px; }
            .brand { justify-content: flex-start; margin: 0 4px 17px; }
            .brand img { width: 82px; height: 52px; }
            .login-grid { grid-template-columns: 1fr; }
            .character-panel { min-height: 265px; padding-top: 38px; border-right: 0; border-bottom: 1px solid #75caff77; }
            .student { width: 190px; max-height: 225px; }
            .character-caption { top: 22px; left: 26px; }
            .character-panel::before { inset: 14px; }
            .character-panel::after { display: none; }
            .form-panel { padding: 32px 27px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>
<body>
    <main class="login-page">
        <div class="login-shell">
            <header class="brand" aria-label="Politeknik Mitra Industri">
                <img src="{{ asset('assets/background/campus.png') }}" alt="Logo Politeknik Mitra Industri">
                <div class="brand-copy">
                    <small>Campus access portal</small>
                    <strong>Politeknik Mitra Industri</strong>
                </div>
            </header>

            <section class="login-grid" aria-labelledby="login-title">
                <aside class="character-panel {{ $errors->has('email') ? 'is-error' : '' }}" aria-label="Pixel art mahasiswa Politeknik Mitra Industri">
                    <p class="character-caption"><span class="status-dot"></span>Academic system online</p>
                    <img class="student" src="{{ asset('assets/character/student-idle.png') }}" alt="Ilustrasi pixel mahasiswa dengan blazer kampus">
                </aside>

                <div class="form-panel {{ $errors->has('email') ? 'is-error' : '' }}">
                    <p class="eyebrow">Member access / 01</p>
                    <h1 id="login-title">Welcome back.</h1>
                    <p class="intro">Masuk untuk melanjutkan ke portal akademik Politeknik Mitra Industri.</p>

                    @if (session('status'))
                        <div class="flash" role="status">
                            <strong>✓</strong>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->has('email'))
                        <div class="flash error" role="alert">
                            <strong>×</strong>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="field">
                            <label for="email">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                placeholder="nama@kampus.ac.id"
                                required
                                autofocus
                            >
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                required
                            >
                            @error('password')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="login-button" type="submit">
                            Login <span aria-hidden="true">›</span>
                        </button>
                    </form>

                    <p class="form-footer">
                        <span>●</span> Gunakan akun akademik Anda untuk mengakses sistem.
                    </p>

                    <p class="form-footer">
                        <span>●</span> Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
