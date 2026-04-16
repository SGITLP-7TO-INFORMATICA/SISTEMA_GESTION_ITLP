<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" type="image/png" href="{{ asset('icons/ITLP_LOGO.png') }}"/>
  <title>@yield('title', 'SGITLP') – Sistema de Gestión</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --bg:          #0f1117;
      --surface:     #181c26;
      --surface2:    #1f2333;
      --border:      rgba(255,255,255,0.07);
      --border2:     rgba(255,255,255,0.13);
      --accent:      #3b82f6;
      --accent2:     #60a5fa;
      --accent-glow: rgba(59,130,246,0.18);
      --text:        #e8eaf0;
      --muted:       #7c8496;
      --muted2:      #555e72;
      --success:     #22c55e;
      --warning:     #f59e0b;
      --danger:      #ef4444;
      --header-h:    58px;
      --radius:      10px;
      --font:        'DM Sans', sans-serif;
      --font-mono:   'DM Mono', monospace;
      --font-display:'Playfair Display', serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Textura de fondo */
    /*body::before {
      content: '';
      position: fixed; inset: 0;
      background-image:
        linear-gradient(var(--border) 1px, transparent 1px),
        linear-gradient(90deg, var(--border) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
      opacity: 0.5;
    }*/

    header, main { position: relative; z-index: 1; }

    /* ── HEADER ── */
    header {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: var(--header-h);
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      z-index: 100;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .logo-mark {
      width: 34px; height: 34px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--accent), #1d4ed8);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 0 16px var(--accent-glow);
    }
    .logo-mark svg { width: 18px; height: 18px; fill: #fff; }

    .brand-title {
      font-family: var(--font-display);
      font-size: 13.5px;
      color: var(--text);
    }

    /* Separador vertical */
    .header-sep {
      width: 1px;
      height: 20px;
      background: var(--border2);
      margin: 0 4px;
    }

    /* Breadcrumb en el header */
    .header-breadcrumb {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 12.5px;
      color: var(--muted);
    }
    .header-breadcrumb a {
      color: var(--muted);
      text-decoration: none;
      transition: color .15s;
    }
    .header-breadcrumb a:hover { color: var(--accent2); }
    .bc-sep { color: var(--muted2); font-size: 11px; margin: 0 2px; }
    .bc-current { color: var(--text); font-weight: 500; }

    /* Volver al dashboard */
    .btn-back {
      display: flex; align-items: center; gap: 6px;
      font-size: 12px;
      color: var(--muted);
      text-decoration: none;
      padding: 6px 12px;
      border: 1px solid var(--border2);
      border-radius: 8px;
      transition: color .2s, border-color .2s;
    }
    .btn-back:hover { color: var(--accent2); border-color: var(--accent); }
    .btn-back svg { width: 13px; height: 13px; }

    .header-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Usuario */
    .user-chip {
      display: flex; align-items: center; gap: 8px;
      padding: 4px 10px 4px 4px;
      border: 1px solid var(--border2);
      border-radius: 10px;
    }
    .user-avatar {
      width: 28px; height: 28px; border-radius: 7px;
      background: linear-gradient(135deg, #1e3a5f, #2563eb);
      display: flex; align-items: center; justify-content: center;
      font-size: 11px; font-weight: 600; color: #fff;
    }
    .user-name { font-size: 12px; color: var(--muted); }

    /* ── MAIN ── */
    main {
      margin-top: var(--header-h);
      flex: 1;
      padding: 32px 40px;
      max-width: 1100px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    /* Encabezado de página */
    .page-header {
      margin-bottom: 24px;
    }
    .page-title {
      font-family: var(--font-display);
      font-size: 22px;
      color: var(--text);
    }
    .page-breadcrumb {
      font-size: 11.5px;
      color: var(--muted);
      margin-top: 4px;
    }
    .page-breadcrumb a {
      color: var(--accent2);
      text-decoration: none;
    }
    .page-breadcrumb a:hover { text-decoration: underline; }

    /* Panel contenedor */
    .abm-panel {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
    }

    .abm-panel-head {
      padding: 16px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .abm-panel-title {
      font-size: 13px;
      font-weight: 500;
      color: var(--text);
    }

    .abm-panel-body {
      padding: 24px;
    }

    /* Animación entrada */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-1 { animation: fadeUp .35s ease both; animation-delay: .00s; }
    .fade-2 { animation: fadeUp .35s ease both; animation-delay: .07s; }
    .fade-3 { animation: fadeUp .35s ease both; animation-delay: .14s; }
  </style>
  @stack('styles')
</head>
<body>

<!-- ══ HEADER ══ -->
<header>
  <div class="header-left">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2L3 7v10l9 5 9-5V7L12 2zm0 2.18L19 8v8.82L12 20.82 5 16.82V8l7-3.82z"/></svg>
    </div>
    <span class="brand-title">SGITLP</span>
    <div class="header-sep"></div>

    {{-- Breadcrumb dinámico: siempre arranca con "Panel principal".
         Si la vista define @section('breadcrumb'), se agrega el trail.
         El último segmento siempre es el @yield('title') en negrita. --}}
    <nav class="header-breadcrumb">
      <a href="{{ route('dashboard') }}">Panel principal</a>
      @hasSection('breadcrumb')
        <span class="bc-sep">/</span>
        @yield('breadcrumb')
        <span class="bc-sep">/</span>
      @endif
      <span class="bc-current">@yield('title', 'Panel')</span>
    </nav>
  </div>

  <div class="header-right">
    <a href="{{ route('dashboard') }}" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="15 18 9 12 15 6"/>
      </svg>
      Volver al panel
    </a>

    <div class="user-chip">
      <div class="user-avatar">
        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'US' }}
      </div>
      <span class="user-name">
        {{ auth()->check() ? auth()->user()->name : 'Usuario' }}
      </span>
    </div>
  </div>
</header>

<!-- ══ CONTENIDO ══ -->
<main>
  @yield('content')
</main>

@stack('scripts')
</body>
</html>