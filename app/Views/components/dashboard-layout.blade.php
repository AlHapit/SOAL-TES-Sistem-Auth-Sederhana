@props(['role', 'title', 'character', 'world' => ''])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title }} | Polimind</title>
    <style>
        :root { --navy:#061936; --blue:#1684df; --ice:#dff2ff; --line:#72cfff; --panel:#09284ee8; --warm:#6b4027 }
        * { box-sizing:border-box }
        body { margin:0; min-width:320px; color:#f5fbff; font:15px/1.5 Inter,system-ui,sans-serif; background:#061936 }
        .world { min-height:100vh; padding:20px; background:linear-gradient(135deg,#05152dde,#0d3a65d9),url('{{ asset('assets/background/campus.png') }}') center/cover fixed }
        .shell { max-width:1180px; margin:auto }
        .top { display:flex; gap:16px; align-items:center; justify-content:space-between; padding:13px 16px; border:1px solid #76d0ff88; background:#061a39e8 }
        .identity { display:flex; gap:11px; align-items:center }
        .identity img { width:66px; height:42px; object-fit:cover; image-rendering:pixelated }
        .identity b,.tag,.button { font-family:"Courier New",monospace; letter-spacing:.09em; text-transform:uppercase }
        .identity small { display:block; color:#9cdcff; font-size:10px }
        .nav { display:flex; align-items:center; gap:10px }
        .tag { padding:5px 8px; border:1px solid #63bfff88; color:#aae3ff; font-size:10px }
        .button { border:1px solid #8ddaff; background:#a8e1ff; color:#061936; padding:9px 12px; font-weight:bold; cursor:pointer; text-decoration:none }
        .button.danger { background:transparent; color:#d8efff }
        .hero { position:relative; display:grid; grid-template-columns:1.25fr .75fr; min-height:330px; margin-top:18px; overflow:hidden; border:1px solid #6bc8ff88; background:linear-gradient(120deg,#103f70e6,#071d3de8) }
        .hero:before { content:""; position:absolute; inset:0; opacity:.25; background-image:linear-gradient(#80d5ff33 1px,transparent 1px),linear-gradient(90deg,#80d5ff33 1px,transparent 1px); background-size:28px 28px }
        .hero-copy { z-index:1; padding:clamp(28px,5vw,60px) }
        .eyebrow { margin:0; color:#9adfff; font:700 11px "Courier New",monospace; letter-spacing:.12em; text-transform:uppercase }
        .hero h1 { margin:8px 0; font-size:clamp(30px,5vw,50px); letter-spacing:-.04em }
        .hero p { max-width:520px; color:#c3d9ea }
        .character { z-index:1; align-self:end; justify-self:center; max-height:310px; max-width:100%; object-fit:contain; image-rendering:pixelated; filter:drop-shadow(0 16px 14px #0009); animation:idle 4s ease-in-out infinite }
        .grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-top:18px }
        .card { padding:18px; border:1px solid #71c9ff77; background:var(--panel); box-shadow:inset 0 0 0 1px #fff1 }
        .card h2 { margin:0 0 8px; font-size:14px; color:#a9e3ff; font-family:"Courier New",monospace; letter-spacing:.08em; text-transform:uppercase }
        .card strong { font-size:20px }
        .flash { margin-top:16px; padding:11px; border-left:3px solid #85dbff; background:#0c4972; color:#effbff }
        .manage { margin-top:18px }
        .table-wrap { overflow-x:auto }
        .data { width:100%; border-collapse:collapse; min-width:560px }
        .data th,.data td { padding:11px; border-bottom:1px solid #69bfff33; text-align:left }
        .data th { color:#9cdcff; font:11px "Courier New",monospace; letter-spacing:.08em; text-transform:uppercase }
        .inline { display:flex; gap:8px; align-items:center }
        .mini { padding:6px 8px; border:1px solid #74c9ff; background:#123c65; color:#ecfaff }
        .mini.danger { border-color:#ff9999; color:#ffd0d0; background:#4a1924 }
        .new-user { display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:8px; margin:14px 0 }
        .new-user input { min-width:0; padding:9px; border:1px solid #6fcaff; background:#061b39; color:white }
        .egg { position:absolute; bottom:15px; left:-180px; font:11px "Courier New",monospace; color:#d9f4ff; animation:run 9s linear 6s infinite }
        .book { position:absolute; right:30%; top:25px; color:#ffd58a; font-size:26px; animation:fall 7s ease-in 3s infinite }
        @keyframes idle { 50% { transform:translateY(-5px) } }
        @keyframes run { 0%,75% { left:-180px } 100% { left:110% } }
        @keyframes fall { 0%,60% { transform:translateY(-80px); opacity:0 } 78% { transform:translateY(170px); opacity:1 } 100% { transform:translateY(170px); opacity:0 } }
        @media (max-width:700px) {
            .world { padding:10px }
            .top { align-items:flex-start }
            .identity b { font-size:12px }
            .nav { flex-direction:column; align-items:flex-end }
            .hero { grid-template-columns:1fr; min-height:0 }
            .character { max-height:220px }
            .grid { grid-template-columns:1fr }
            .new-user { grid-template-columns:1fr }
            .tag { font-size:9px }
        }
    </style>
</head>
<body>
    <main class="world">
        <div class="shell">
            <header class="top">
                <div class="identity">
                    <img src="{{ asset('assets/background/campus.png') }}" alt="Politeknik Mitra Industri">
                    <div>
                        <small>Living Pixel Campus</small>
                        <b>Politeknik Mitra Industri</b>
                    </div>
                </div>

                <div class="nav">
                    <span class="tag">{{ $role }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button danger">Logout</button>
                    </form>
                </div>
            </header>

            @if (session('status'))
                <p class="flash" role="status">{{ session('status') }}</p>
            @endif

            <section class="hero {{ $world }}">
                <div class="hero-copy">
                    <p class="eyebrow">{{ $role }} / campus portal</p>
                    <h1>{{ $title }}, {{ auth()->user()->name }}</h1>
                    <p>{{ $slot->attributes->get('intro', 'Portal akademik Politeknik Mitra Industri.') }}</p>
                </div>

                <img class="character" src="{{ asset($character) }}" alt="Karakter pixel {{ $role }}">
                <span class="book" aria-hidden="true">▰</span>
                <span class="egg" aria-hidden="true">🏫 RUNNING CAMPUS EGG →</span>
            </section>

            {{ $slot }}
        </div>
    </main>
</body>
</html>
