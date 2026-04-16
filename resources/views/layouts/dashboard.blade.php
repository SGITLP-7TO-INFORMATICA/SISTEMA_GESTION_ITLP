<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'SIGITLP') – Sistema de Gestión</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>
  <style>
    /* ── Variables ── */
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
      --info:        #06b6d4;
      --sidebar-w:   260px;
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
      overflow: hidden;
    }

    /* Textura de grilla sutil en el fondo */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(var(--border) 1px, transparent 1px),
        linear-gradient(90deg, var(--border) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
      opacity: 0.5;
    }
    header, aside, main { position: relative; z-index: 1; }

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
      padding: 0 20px 0 0;
      z-index: 100;
    }

    .header-brand {
      display: flex;
      align-items: center;
      width: var(--sidebar-w);
      padding: 0 20px;
      border-right: 1px solid var(--border);
      height: 100%;
      gap: 12px;
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

    .brand-text { display: flex; flex-direction: column; }
    .brand-title { font-family: var(--font-display); font-size: 13.5px; color: var(--text); line-height: 1.1; }
    .brand-sub   { font-size: 9.5px; color: var(--muted); letter-spacing: 0.12em; text-transform: uppercase; font-weight: 500; margin-top: 2px; }

    .header-right { display: flex; align-items: center; gap: 16px; }

    .notif-btn {
      position: relative;
      background: none;
      border: 1px solid var(--border2);
      border-radius: 8px;
      width: 34px; height: 34px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      color: var(--muted);
      transition: border-color .2s, color .2s;
    }
    .notif-btn:hover { border-color: var(--accent); color: var(--accent2); }
    .notif-dot {
      position: absolute; top: 7px; right: 7px;
      width: 6px; height: 6px;
      background: var(--danger);
      border-radius: 50%;
      border: 1.5px solid var(--surface);
    }

    .user-menu {
      position: relative;
      display: flex; align-items: center; gap: 10px;
      padding: 5px 10px 5px 5px;
      border: 1px solid var(--border2);
      border-radius: 10px;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      user-select: none;
    }
    .user-menu:hover { border-color: var(--accent); background: var(--surface2); }

    .user-avatar {
      width: 30px; height: 30px; border-radius: 8px;
      background: linear-gradient(135deg, #1e3a5f, #2563eb);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0;
    }
    .user-info { display: flex; flex-direction: column; }
    .user-name  { font-size: 12.5px; font-weight: 500; color: var(--text); line-height: 1.2; }
    .user-role  { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; }
    .chevron    { color: var(--muted); font-size: 10px; margin-left: 2px; transition: transform .2s; }
    .user-menu.open .chevron { transform: rotate(180deg); }

    .dropdown {
      display: none;
      position: absolute;
      top: calc(100% + 8px); right: 0;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: var(--radius);
      width: 200px; padding: 6px;
      box-shadow: 0 16px 40px rgba(0,0,0,0.5);
      z-index: 200;
    }
    .user-menu.open .dropdown { display: block; }

    .dropdown-item {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 10px; border-radius: 7px;
      font-size: 13px; color: var(--muted);
      cursor: pointer; transition: background .15s, color .15s;
    }
    .dropdown-item:hover { background: var(--border); color: var(--text); }
    .dropdown-item.danger:hover { background: rgba(239,68,68,0.1); color: var(--danger); }
    .dropdown-sep { height: 1px; background: var(--border); margin: 4px 0; }

    /* ── LAYOUT ── */
    .app-body {
      display: flex;
      margin-top: var(--header-h);
      height: calc(100vh - var(--header-h));
      overflow: hidden;
    }

    /* ── SIDEBAR ── */
    aside {
      width: var(--sidebar-w);
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      overflow-y: auto; flex-shrink: 0;
      padding: 12px 0;
    }
    aside::-webkit-scrollbar { width: 4px; }
    aside::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 4px; }

    .nav-section-label {
      font-size: 9.5px; font-weight: 600;
      letter-spacing: 0.14em; text-transform: uppercase;
      color: var(--muted2); padding: 14px 18px 6px;
    }

    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 18px; font-size: 13px; color: var(--muted);
      cursor: pointer; position: relative;
      transition: color .15s, background .15s;
      text-decoration: none; /* para cuando usemos <a> */
    }
    .nav-item:hover { color: var(--text); background: rgba(255,255,255,0.04); }
    .nav-item.active { color: var(--accent2); background: var(--accent-glow); }
    .nav-item.active::before {
      content: '';
      position: absolute; left: 0; top: 4px; bottom: 4px;
      width: 3px; background: var(--accent); border-radius: 0 3px 3px 0;
    }
    .nav-item .icon { width: 16px; height: 16px; opacity: 0.8; flex-shrink: 0; }
    .nav-item.active .icon { opacity: 1; }

    .nav-group-toggle {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 18px; font-size: 13px; color: var(--muted);
      cursor: pointer; transition: color .15s, background .15s; user-select: none;
    }
    .nav-group-toggle:hover { color: var(--text); background: rgba(255,255,255,0.04); }
    .nav-group-toggle .icon { width: 16px; height: 16px; opacity: 0.75; flex-shrink: 0; }
    .nav-group-toggle .arrow { margin-left: auto; font-size: 10px; transition: transform .2s; color: var(--muted2); }
    .nav-group.open .nav-group-toggle .arrow { transform: rotate(90deg); }
    .nav-group.open .nav-group-toggle { color: var(--text); }

    .nav-subitems { display: none; padding-left: 44px; padding-bottom: 4px; }
    .nav-group.open .nav-subitems { display: block; }

    .nav-subitem {
      display: flex; align-items: center; gap: 8px;
      padding: 6px 10px; font-size: 12.5px; color: var(--muted);
      cursor: pointer; border-radius: 6px;
      transition: color .15s, background .15s;
      text-decoration: none;
    }
    .nav-subitem::before {
      content: ''; width: 5px; height: 5px; border-radius: 50%;
      background: var(--muted2); flex-shrink: 0; transition: background .15s;
    }
    .nav-subitem:hover { color: var(--text); background: rgba(255,255,255,0.04); }
    .nav-subitem:hover::before { background: var(--accent); }
    .nav-subitem.active { color: var(--accent2); }
    .nav-subitem.active::before { background: var(--accent); }

    .badge {
      margin-left: auto; font-size: 10px; font-weight: 600;
      padding: 1px 6px; border-radius: 20px; font-family: var(--font-mono);
    }
    .badge-blue { background: var(--accent-glow); color: var(--accent2); }
    .badge-red  { background: rgba(239,68,68,0.15); color: var(--danger); }

    .nav-sep { height: 1px; background: var(--border); margin: 8px 14px; }

    /* ── MAIN ── */
    main {
      flex: 1; overflow-y: auto;
      padding: 28px; background: var(--bg);
    }
    main::-webkit-scrollbar { width: 4px; }
    main::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 4px; }

    /* Animaciones de entrada */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-1 { animation: fadeUp .4s ease both; animation-delay: .00s; }
    .fade-2 { animation: fadeUp .4s ease both; animation-delay: .06s; }
    .fade-3 { animation: fadeUp .4s ease both; animation-delay: .12s; }
  </style>
  @stack('styles')
</head>
<body>

<!-- ══ HEADER ══ -->
<header>
  <div class="header-brand">
      <img 
          src="{{ asset('icons/ITLP_LOGO.png') }}" 
          alt="Logo ITLP" 
          style="height: 55px; width: auto; border-radius: 6px;"
      />
      <div class="brand-text">
          <span class="brand-title">Sistema de Gestión</span>
          <span class="brand-sub">ITLP · Instituto Técnico</span>
      </div>
  </div>

  <div class="header-right">
    <button class="notif-btn" title="Notificaciones">
      <span class="notif-dot"></span>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
    </button>

    <div class="user-menu" id="userMenu" onclick="toggleMenu()">
      <div class="user-avatar">
        {{-- Iniciales del usuario autenticado (cuando Laravel tenga auth) --}}
        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'US' }}
      </div>
      <div class="user-info">
        <span class="user-name">{{ auth()->check() ? auth()->user()->name : 'Usuario' }}</span>
        <span class="user-role">Docente</span>
      </div>
      <span class="chevron">▼</span>

      <div class="dropdown">
        <div class="dropdown-item">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Mi perfil
        </div>
        <div class="dropdown-item">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 19.07"/><path d="M4.93 4.93a10 10 0 0 0 14.14 14.14"/></svg>
          Configuración
        </div>
        <div class="dropdown-sep"></div>
        {{-- Formulario de logout: POST por seguridad (protección CSRF de Laravel) --}}
        {{-- action apunta a la ruta 'logout' definida en routes/web.php --}}
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
          @csrf
          <button type="submit" class="dropdown-item danger" style="width:100%;background:none;border:none;font-family:inherit;cursor:pointer;text-align:left">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
          </button>
        </form>
      </div>
    </div>
  </div>
</header>

<!-- ══ APP BODY ══ -->
<div class="app-body">

  <!-- ── SIDEBAR ── -->
  <aside>
    <div class="nav-section-label">Principal</div>

    {{-- El helper request()->routeIs() detecta qué ruta está activa para marcarla --}}
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Panel principal
    </a>

    <div class="nav-sep"></div>
    <div class="nav-section-label">Módulos</div>

    <!-- Preceptoría -->
    <div class="nav-group {{ request()->is('preceptoria*') ? 'open' : '' }}" id="grp-preceptoria">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-preceptoria')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Preceptoría
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="#" class="nav-subitem">Horarios</a>
        <a href="#" class="nav-subitem">Asistencia</a>
        <a href="#" class="nav-subitem">Actas de convivencia</a>
        <a href="#" class="nav-subitem">Importar planilla <span class="badge badge-blue">Excel</span></a>
      </div>
    </div>

    <!-- Dirección -->
    <div class="nav-group {{ request()->is('direccion*') ? 'open' : '' }}" id="grp-direccion">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-direccion')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Dirección
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="#" class="nav-subitem">Reportes generales</a>
        <a href="#" class="nav-subitem">Resoluciones</a>
        <a href="#" class="nav-subitem">Calendario institucional</a>
      </div>
    </div>

    <!-- Administración -->
    <div class="nav-group {{ request()->is('admin*') ? 'open' : '' }}" id="grp-admin">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-admin')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        Administración
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="#" class="nav-subitem">Alumnos</a>
        <a href="#" class="nav-subitem">Docentes</a>
        <a href="#" class="nav-subitem">Cursos y divisiones</a>
        <a href="#" class="nav-subitem">Materias</a>
      </div>
    </div>

    <!-- Docentes -->
    {{-- request()->is('docentes*') abre el grupo automáticamente cuando estamos en cualquier ruta /docentes/... --}}
    <div class="nav-group {{ request()->is('docentes*') ? 'open' : '' }}" id="grp-docentes">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-docentes')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>
        Docentes
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="{{ route('docentes.tomar-lista') }}"
           class="nav-subitem {{ request()->routeIs('docentes.tomar-lista') ? 'active' : '' }}">
          Tomar lista
        </a>
        <a href="{{ route('docentes.libro-temas') }}"
           class="nav-subitem {{ request()->routeIs('docentes.libro-temas') ? 'active' : '' }}">
          Libro de temas
        </a>
        <a href="#" class="nav-subitem">Reporte asistencias</a>
      </div>
    </div>

    <!-- Comunicaciones -->
    <div class="nav-group {{ request()->is('comunicaciones*') ? 'open' : '' }}" id="grp-com">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-com')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Comunicaciones
        <span class="badge badge-red">3</span>
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="#" class="nav-subitem">Circulares</a>
        <a href="#" class="nav-subitem">Mensajes internos <span class="badge badge-red">3</span></a>
        <a href="#" class="nav-subitem">Tablón de anuncios</a>
      </div>
    </div>

    <div class="nav-sep"></div>
    <div class="nav-section-label">Sistema</div>

    <a href="#" class="nav-item">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 19.07"/><path d="M4.93 4.93a10 10 0 0 0 14.14 14.14"/></svg>
      Configuración
    </a>
    <a href="#" class="nav-item">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Ayuda
    </a>
  </aside>

  <!-- ── CONTENIDO PRINCIPAL (cada vista lo llena) ── -->
  <main>
    @yield('content')
  </main>

</div>

<script>
  function toggleMenu() {
    document.getElementById('userMenu').classList.toggle('open');
  }
  // Cierra el dropdown si se hace clic afuera
  document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (!menu.contains(e.target)) menu.classList.remove('open');
  });

  function toggleGroup(id) {
    document.getElementById(id).classList.toggle('open');
  }
</script>
@stack('scripts')
</body>
</html>