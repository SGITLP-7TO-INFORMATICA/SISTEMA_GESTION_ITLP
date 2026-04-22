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
  @vite(['resources/css/app.css'])
  <style>
    
  </style>
</head>
<body class="font-sans bg-bg text-content min-h-screen flex items-center justify-center">

<div class="absolute w-full h-full inset-0 opacity-20">
  <img src="{{ asset('images/login/login_bg_img.jpg') }}" alt="Logo ITLP" class="w-full h-full object-cover blur-[10px] rounded-[1px]">
</div>

<div class="relative z-[1] bg-surface/70 border border-dim2 rounded-2xl p-10 w-full max-w-[420px] shadow-[0_24px_60px_rgba(0,0,0,0.5)] fade-1">
  
  {{-- Cabecera de la institución --}}
  <div class="flex flex-col items-center gap-[14px] mb-8">
    <div class="w-[150px] h-[150px] rounded-[10px]  flex items-center justify-center ">
      <img src="{{ asset('icons/ITLP_LOGO.png') }}" alt="Logo ITLP" class="w-full h-full object-contain rounded-[10px]">
    </div>
    <div class="flex flex-col gap-0.5">
      <span class="font-display text-[1.6em] text-content">Sistema de Gestión</span>
      <span class="text-[1em] text-muted uppercase tracking-[0.12em]">ITLP · Instituto Técnico</span>
    </div>
  </div>

  @if ($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 rounded-lg px-[14px] py-2.5 text-[13px] text-danger mb-5">
      {{ $errors->first('email') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-[18px]">
      <label for="email" class="block text-[11px] font-semibold text-muted uppercase tracking-[0.1em] mb-1.5">
        Correo electrónico
      </label>
      <input
        type="email"
        id="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="docente@itlp.edu.ar"
        autocomplete="email"
        required
        class="w-full bg-surface2 border rounded-[9px] text-content font-sans text-[14px] px-[14px] py-[11px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)] {{ $errors->has('email') ? 'border-danger' : 'border-dim2' }}"
      />
    </div>

    <div class="mb-[18px]">
      <label for="password" class="block text-[11px] font-semibold text-muted uppercase tracking-[0.1em] mb-1.5">
        Contraseña
      </label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="••••••••"
        autocomplete="current-password"
        required
        class="w-full bg-surface2 border border-dim2 rounded-[9px] text-content font-sans text-[14px] px-[14px] py-[11px] outline-none transition-[border-color,box-shadow] duration-200 focus:border-accent focus:shadow-[0_0_0_3px_var(--color-glow)]"
      />
    </div>

    <div class="flex items-center gap-2 mb-6">
      <input type="checkbox" id="remember" name="remember" class="w-[15px] h-[15px] [accent-color:var(--color-accent)] cursor-pointer" />
      <label for="remember" class="text-[13px] text-muted cursor-pointer">Mantener sesión iniciada</label>
    </div>

    <button type="submit" class="w-full bg-accent text-white border-none rounded-[9px] font-sans text-[14px] font-medium py-3 cursor-pointer shadow-[0_0_24px_var(--color-glow)] transition-[opacity,transform] duration-200 hover:opacity-[0.88] active:scale-[0.99]">
      Iniciar sesión
    </button>
  </form>

  <div class="mt-6 text-center text-[11.5px] text-muted2">
    Sistema de Gestión Institucional &mdash; ITLP &copy; {{ date('Y') }}
  </div>

</div>

</body>
</html>
