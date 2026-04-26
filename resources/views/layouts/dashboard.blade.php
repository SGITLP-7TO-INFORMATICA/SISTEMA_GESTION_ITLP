<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  {{-- @vite compila app.css (Tailwind) y app.js, e inyecta los <link>/<script> correctos.
       En desarrollo apunta al servidor de Vite; en producción usa los archivos del manifest. --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="icon" type="image/png" href="{{ asset('icons/ITLP_LOGO.png') }}"/>
  <title>@yield('title', 'SIGITLP') – Sistema de Gestión</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>
  @stack('styles')
</head>
{{-- bg-bg: color de fondo oscuro (#0f1117) definido en @theme de app.css
     text-content: color de texto principal (#e8eaf0)
     overflow-hidden: evita doble scrollbar (cada sección scrollea independiente) --}}
<body class="bg-bg text-content font-sans min-h-screen flex flex-col overflow-hidden">

<!-- ══ HEADER ══ -->
{{-- h-[58px]: altura fija del header. El sidebar tiene el mismo ancho (260px) para alinearse.
     z-[100]: el header queda por encima del sidebar y del contenido principal. --}}
<header class="fixed top-0 inset-x-0 h-[58px] bg-surface border-b border-dim flex items-center justify-between pr-5 z-[100]">

  {{-- Sección izquierda: logo + nombre de la app.
       El ancho (w-[260px]) coincide exactamente con el sidebar de abajo. --}}
  <div class="flex items-center w-[260px] px-5 border-r border-dim h-full gap-3">
    <img
      src="{{ asset('icons/ITLP_LOGO.png') }}"
      alt="Logo ITLP"
      style="height:55px;width:auto;border-radius:6px"
    />
    <div class="flex flex-col">
      <span class="font-display text-[13.5px] text-content leading-tight">Sistema de Gestión</span>
      <span class="text-[9.5px] text-muted tracking-[0.12em] uppercase font-medium mt-0.5">ITLP · Instituto Técnico</span>
    </div>
  </div>

  {{-- Sección derecha: notificaciones + menú de usuario --}}
  <div class="flex items-center gap-4">
    <button class="notif-btn" title="Notificaciones">
      <span class="notif-dot"></span>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
    </button>

    {{-- .user-menu y sus clases internas (.user-avatar, .dropdown, etc.)
         están definidas en app.css @layer components porque usan estados JS (.open). --}}
    <div class="user-menu" id="userMenu" onclick="toggleMenu()">
      <div class="user-avatar">
        {{ auth()->check() ? strtoupper(substr(auth()->user()->nombre, 0, 1)) . strtoupper(substr(auth()->user()->apellido, 0, 1)) : 'US' }}
      </div>
      <div class="user-info">
        <span class="user-name">{{ auth()->check() ? auth()->user()->nombre . ' ' . auth()->user()->apellido : 'Usuario' }}</span>
        <span class="user-role">{{ auth()->check() ? auth()->user()->nombre_usuario : '' }}</span>
      </div>
      <span class="chevron">▼</span>

      <div class="dropdown">
        <div class="dropdown-item">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Mi usuario
        </div>
        <div class="dropdown-item">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 19.07"/><path d="M4.93 4.93a10 10 0 0 0 14.14 14.14"/></svg>
          Configuración
        </div>
        <div class="dropdown-sep"></div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
          @csrf
          <button type="submit" class="dropdown-item danger">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
          </button>
        </form>
      </div>
    </div>
  </div>
</header>

<!-- ══ APP BODY ══ -->
{{-- mt-[58px]: compensa el header fijo. h-[calc(100vh-58px)]: llena el resto de la pantalla.
     overflow-hidden: el scroll está dentro de aside y main, no del body. --}}
<div class="flex mt-[58px] h-[calc(100vh-58px)] overflow-hidden">

  <!-- ── SIDEBAR ── -->
  {{-- custom-scroll: clase definida en app.css para scrollbar personalizada (4px, oscura).
       shrink-0: evita que el sidebar se comprima cuando el contenido es grande. --}}
  <aside class="w-[260px] bg-surface border-r border-dim flex flex-col overflow-y-auto shrink-0 py-3 custom-scroll">

    {{-- Etiqueta de sección: texto pequeño en mayúsculas como separador visual --}}
    <div class="text-[9.5px] font-semibold tracking-[0.14em] uppercase text-muted2 px-[18px] pt-3.5 pb-1.5">Principal</div>

    {{-- request()->routeIs('dashboard'): helper de Laravel que detecta la ruta activa
         y agrega la clase CSS 'active' que muestra la barra azul lateral. --}}
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Panel principal
    </a>

    {{-- Separador horizontal entre secciones del sidebar --}}
    <div class="h-px bg-dim mx-3.5 my-2"></div>
    <div class="text-[9.5px] font-semibold tracking-[0.14em] uppercase text-muted2 px-[18px] pt-3.5 pb-1.5">Módulos</div>

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
        <a href="#" class="nav-subitem">Importar planilla <span class="ml-auto text-[10px] font-semibold px-1.5 py-px rounded-full font-mono bg-glow text-accent2">Excel</span></a>
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
    <div class="nav-group {{ request()->is('administracion*') ? 'open' : '' }}" id="grp-admin">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-admin')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        Administración
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="{{ route('administracion.alumnos') }}"
           class="nav-subitem {{ request()->routeIs('administracion.alumnos') ? 'active' : '' }}">Alumnos</a>
        <a href="{{ route('administracion.docentes') }}"
           class="nav-subitem {{ request()->routeIs('administracion.docentes') ? 'active' : '' }}">Docentes</a>
        <a href="{{ route('administracion.cursos') }}"
           class="nav-subitem {{ request()->routeIs('administracion.cursos') ? 'active' : '' }}">Cursos y divisiones</a>
        <a href="{{ route('administracion.anios') }}"
           class="nav-subitem {{ request()->routeIs('administracion.anios') ? 'active' : '' }}">Años escolares</a>
        <a href="{{ route('administracion.materias') }}"
           class="nav-subitem {{ request()->routeIs('administracion.materias') ? 'active' : '' }}">Materias</a>
        <a href="{{ route('administracion.materias-dictado') }}"
           class="nav-subitem {{ request()->routeIs('administracion.materias-dictado') ? 'active' : '' }}">Dictado de materias</a>
      </div>
    </div>

    <!-- Docentes -->
    {{-- request()->is('docentes*') abre el grupo automáticamente en cualquier ruta /docentes/... --}}
    <div class="nav-group {{ request()->is('docentes*') ? 'open' : '' }}" id="grp-docentes">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-docentes')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>
        Docentes
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="{{ route('docentes.libro-temas') }}"
           class="nav-subitem {{ request()->routeIs('docentes.libro-temas') ? 'active' : '' }}">
          Libro de temas
        </a>
        <a href="{{ route('docentes.tomar-lista') }}"
           class="nav-subitem {{ request()->routeIs('docentes.tomar-lista') ? 'active' : '' }}">
          Tomar lista
        </a>
        <a href="{{ route('docentes.trabajos-practicos') }}"
           class="nav-subitem {{ request()->routeIs('docentes.trabajos-practicos') ? 'active' : '' }}">
          Trabajos prácticos
        </a>
        <a href="{{ route('docentes.exportar-registros') }}"
           class="nav-subitem {{ request()->routeIs('docentes.exportar-registros') ? 'active' : '' }}">
          Exportar Registros Clases
        </a>
      </div>
    </div>

    <!-- Comunicaciones -->
    <div class="nav-group {{ request()->is('comunicaciones*') ? 'open' : '' }}" id="grp-com">
      <div class="nav-group-toggle" onclick="toggleGroup('grp-com')">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Comunicaciones
        <span class="ml-auto text-[10px] font-semibold px-1.5 py-px rounded-full font-mono bg-red-500/15 text-danger">3</span>
        <span class="arrow">▶</span>
      </div>
      <div class="nav-subitems">
        <a href="#" class="nav-subitem">Circulares</a>
        <a href="#" class="nav-subitem">Mensajes internos <span class="ml-auto text-[10px] font-semibold px-1.5 py-px rounded-full font-mono bg-red-500/15 text-danger">3</span></a>
        <a href="#" class="nav-subitem">Tablón de anuncios</a>
      </div>
    </div>

    <div class="h-px bg-dim mx-3.5 my-2"></div>
    <div class="text-[9.5px] font-semibold tracking-[0.14em] uppercase text-muted2 px-[18px] pt-3.5 pb-1.5">Sistema</div>

    <a href="#" class="nav-item">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 4.93 19.07"/><path d="M4.93 4.93a10 10 0 0 0 14.14 14.14"/></svg>
      Configuración
    </a>
    <a href="#" class="nav-item">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Ayuda
    </a>
  </aside>

  <!-- ── CONTENIDO PRINCIPAL (cada vista lo llena con @section('content')) ── -->
  {{-- p-7: padding interno de 28px. custom-scroll: scrollbar personalizada. --}}
  <main class="flex-1 overflow-y-auto p-7 bg-bg custom-scroll">
    @yield('content')
  </main>

</div>

<script>
  function toggleMenu() {
    document.getElementById('userMenu').classList.toggle('open');
  }
  // Cierra el dropdown si el usuario hace clic fuera de él
  document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (!menu.contains(e.target)) menu.classList.remove('open');
  });

  // Abre/cierra los grupos del sidebar (acordeón)
  function toggleGroup(id) {
    document.getElementById(id).classList.toggle('open');
  }
</script>
@stack('scripts')
</body>
</html>
