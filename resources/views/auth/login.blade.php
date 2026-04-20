<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" type="image/png" href="{{ asset('icons/ITLP_LOGO.png') }}"/>
  <title>Iniciar sesión – SGITLP</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --bg:          #0f1117;
      --bg-transparent-50:          #0f1117b2;
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
      --danger:      #ef4444;
      --success:     #22c55e;
      --radius:      10px;
      --font:        'DM Sans', sans-serif;
      --font-display:'Playfair Display', serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Grilla de fondo sutil */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image:
        linear-gradient(var(--border) 1px, transparent 1px),
        linear-gradient(90deg, var(--border) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      opacity: 0.5;
    }

    .login-card {
      position: relative; z-index: 1;
      background: var(--surface);
      border: 1px solid var(--border2);
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 24px 60px rgba(0,0,0,0.5);
      animation: fadeUp .4s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Logo / cabecera */
    .login-header {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 32px;
    }
    .logo-mark {
      width: 42px; height: 42px; border-radius: 10px;
      background: linear-gradient(135deg, var(--accent), #1d4ed8);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 0 20px var(--accent-glow);
    }
    .logo-mark svg { width: 22px; height: 22px; fill: #fff; }
    .brand { display: flex; flex-direction: column; gap: 2px; }
    .brand-name {
      font-family: var(--font-display);
      font-size: 15px;
      color: var(--text);
    }
    .brand-sub {
      font-size: 10px;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.12em;
    }

    /* Título */
    .login-title {
      font-size: 20px;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 6px;
    }
    .login-subtitle {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 28px;
    }

    /* Campos */
    .form-group {
      margin-bottom: 18px;
    }
    label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 6px;
    }
    input[type="email"],
    input[type="password"] {
      width: 100%;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 9px;
      color: var(--text);
      font-family: var(--font);
      font-size: 14px;
      padding: 11px 14px;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    input.is-error {
      border-color: var(--danger);
    }

    /* Checkbox remember */
    .remember-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 24px;
    }
    .remember-row input[type="checkbox"] {
      width: 15px; height: 15px;
      accent-color: var(--accent);
      cursor: pointer;
    }
    .remember-row label {
      font-size: 13px;
      color: var(--muted);
      text-transform: none;
      letter-spacing: 0;
      margin: 0;
      cursor: pointer;
    }

    /* Mensaje de error */
    .error-msg {
      font-size: 12px;
      color: var(--danger);
      margin-top: 5px;
    }

    /* Alerta general de error */
    .alert-error {
      background: rgba(239,68,68,0.08);
      border: 1px solid rgba(239,68,68,0.3);
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 13px;
      color: var(--danger);
      margin-bottom: 20px;
    }

    /* Botón de submit */
    .btn-login {
      width: 100%;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 9px;
      font-family: var(--font);
      font-size: 14px;
      font-weight: 500;
      padding: 12px;
      cursor: pointer;
      box-shadow: 0 0 24px var(--accent-glow);
      transition: opacity .2s, transform .1s;
    }
    .btn-login:hover { opacity: .88; }
    .btn-login:active { transform: scale(.99); }

    /* Footer */
    .login-footer {
      margin-top: 24px;
      text-align: center;
      font-size: 11.5px;
      color: var(--muted2);
    }
  </style>
</head>
<body>

<div class="login-card">

  {{-- Cabecera de la institución --}}
  <div class="login-header">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24"><path d="M12 2L3 7v10l9 5 9-5V7L12 2zm0 2.18L19 8v8.82L12 20.82 5 16.82V8l7-3.82z"/></svg>
    </div>
    <div class="brand">
      <span class="brand-name">Sistema de Gestión</span>
      <span class="brand-sub">ITLP · Instituto Técnico</span>
    </div>
  </div>

  <div class="login-title">Bienvenido</div>
  <div class="login-subtitle">Ingresá tus credenciales para continuar.</div>

  {{-- Alerta de error general (aparece cuando hay errores de validación) --}}
  {{-- $errors es una variable que Laravel siempre inyecta en las vistas.
       Contiene todos los errores de validación de la request anterior. --}}
  @if ($errors->any())
    <div class="alert-error">
      {{ $errors->first('email') }}
    </div>
  @endif

  {{-- Formulario de login --}}
  {{-- action: ruta POST donde se procesa el login
       @csrf: directiva de Blade que agrega un campo oculto con el token CSRF.
       Laravel rechaza cualquier POST sin este token (protección contra ataques cross-site). --}}
  <form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="form-group">
      <label for="email">Correo electrónico</label>
      {{-- old('email') restaura el valor que escribió el usuario si hubo error --}}
      <input
        type="email"
        id="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="docente@itlp.edu.ar"
        autocomplete="email"
        class="{{ $errors->has('email') ? 'is-error' : '' }}"
        required
      />
    </div>

    <div class="form-group">
      <label for="password">Contraseña</label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="••••••••"
        autocomplete="current-password"
        required
      />
    </div>

    {{-- "Recordarme": si está activo, Laravel guarda una cookie larga duración
         en lugar de una sesión que expira al cerrar el navegador. --}}
    <div class="remember-row">
      <input type="checkbox" id="remember" name="remember" />
      <label for="remember">Mantener sesión iniciada</label>
    </div>

    <button type="submit" class="btn-login">Iniciar sesión</button>
  </form>

  <div class="login-footer">
    Sistema de Gestión Institucional &mdash; ITLP &copy; {{ date('Y') }}
  </div>

</div>

</body>
</html>
