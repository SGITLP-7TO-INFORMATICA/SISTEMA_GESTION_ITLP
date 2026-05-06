{{--
  Componente: <x-session-modal />
  Detecta sesión expirada en cualquier submit de formulario y muestra un modal de re-login inline.
  Funciona en desktop y mobile. Incluirlo al final del <body> en cada layout protegido.
--}}

<!-- ══ MODAL: SESIÓN EXPIRADA ══ -->
<div id="session-modal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.65); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:16px;">
  <div style="background:var(--surface2); border:1px solid var(--border2); border-radius:16px; padding:32px 28px; max-width:400px; width:100%; box-shadow:0 24px 60px rgba(0,0,0,.6);">

    {{-- Ícono --}}
    <div style="width:44px;height:44px;border-radius:11px;background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.3);margin:0 auto 18px;display:flex;align-items:center;justify-content:center;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
    </div>

    <h3 style="font-family:var(--font-display);font-size:17px;color:var(--text);margin:0 0 6px;text-align:center;">Tu sesión expiró</h3>
    <p style="font-size:12.5px;color:var(--muted);line-height:1.6;margin:0 0 22px;text-align:center;">Iniciá sesión de nuevo para continuar. Tus datos no se van a perder.</p>

    {{-- Error de credenciales --}}
    <div id="session-modal-error" style="display:none; background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.3); border-radius:8px; padding:9px 13px; font-size:12.5px; color:#fca5a5; margin-bottom:16px;"></div>

    {{-- Formulario de re-login --}}
    <div style="display:flex; flex-direction:column; gap:13px;">
      <div>
        <label style="display:block; font-size:10.5px; font-weight:600; color:var(--muted2); text-transform:uppercase; letter-spacing:.1em; margin-bottom:6px;">Correo electrónico</label>
        <input
          id="sm-email"
          type="email"
          autocomplete="email"
          placeholder="docente@itlp.edu.ar"
          style="width:100%; background:var(--surface); border:1px solid var(--border2); border-radius:9px; color:var(--text); font-family:var(--font); font-size:13.5px; padding:10px 13px; outline:none; box-sizing:border-box; transition:border-color .2s;"
          onfocus="this.style.borderColor='var(--accent)'"
          onblur="this.style.borderColor='var(--border2)'"
        />
      </div>
      <div>
        <label style="display:block; font-size:10.5px; font-weight:600; color:var(--muted2); text-transform:uppercase; letter-spacing:.1em; margin-bottom:6px;">Contraseña</label>
        <input
          id="sm-password"
          type="password"
          autocomplete="current-password"
          placeholder="••••••••"
          style="width:100%; background:var(--surface); border:1px solid var(--border2); border-radius:9px; color:var(--text); font-family:var(--font); font-size:13.5px; padding:10px 13px; outline:none; box-sizing:border-box; transition:border-color .2s;"
          onfocus="this.style.borderColor='var(--accent)'"
          onblur="this.style.borderColor='var(--border2)'"
        />
      </div>
    </div>

    {{-- Botones --}}
    <div style="display:flex; gap:10px; margin-top:20px;">
      <button
        id="btn-cancel-modal"
        type="button"
        style="flex:1; padding:11px; border-radius:9px; border:1px solid var(--border2); background:transparent; color:var(--muted); font-family:var(--font); font-size:13px; cursor:pointer;"
      >Cancelar</button>
      <button
        id="btn-relogin"
        type="button"
        style="flex:2; padding:11px; border-radius:9px; border:none; background:var(--accent); color:#fff; font-family:var(--font); font-size:13px; font-weight:600; cursor:pointer; box-shadow:0 4px 16px rgba(59,130,246,.35); transition:opacity .2s;"
      >Iniciar sesión</button>
    </div>

  </div>
</div>

<script>
(function () {
  let pendingForm = null;

  function showModal(form) {
    pendingForm = form;
    document.getElementById('session-modal-error').style.display = 'none';
    document.getElementById('sm-email').value    = '';
    document.getElementById('sm-password').value = '';
    document.getElementById('session-modal').style.display = 'flex';
    setTimeout(() => document.getElementById('sm-email').focus(), 100);
  }

  function hideModal() {
    document.getElementById('session-modal').style.display = 'none';
    pendingForm = null;
  }

  function showError(msg) {
    const el = document.getElementById('session-modal-error');
    el.textContent = msg;
    el.style.display = 'block';
  }

  function setLoading(loading) {
    const btn = document.getElementById('btn-relogin');
    btn.disabled    = loading;
    btn.textContent = loading ? 'Iniciando sesión…' : 'Iniciar sesión';
    btn.style.opacity = loading ? '.6' : '1';
  }

  document.getElementById('btn-cancel-modal').addEventListener('click', hideModal);

  // Permitir submit con Enter dentro del modal
  ['sm-email', 'sm-password'].forEach(function(id) {
    document.getElementById(id).addEventListener('keydown', function(e) {
      if (e.key === 'Enter') doLogin();
    });
  });

  async function doLogin() {
    const email    = document.getElementById('sm-email').value.trim();
    const password = document.getElementById('sm-password').value;

    if (!email || !password) {
      showError('Completá el email y la contraseña.');
      return;
    }

    setLoading(true);
    document.getElementById('session-modal-error').style.display = 'none';

    try {
      // 1. Obtener un CSRF token fresco (endpoint público)
      const csrfRes = await fetch('/csrf-token-public', { headers: { Accept: 'application/json' } });
      const { token: csrfToken } = await csrfRes.json();

      // 2. Hacer el login vía AJAX
      const loginRes = await fetch('/login', {
        method:  'POST',
        headers: {
          'Content-Type':  'application/json',
          'Accept':        'application/json',
          'X-CSRF-TOKEN':  csrfToken,
        },
        body: JSON.stringify({ email, password }),
      });

      if (!loginRes.ok) {
        const data = await loginRes.json().catch(() => ({}));
        showError(data.error || 'Credenciales incorrectas.');
        setLoading(false);
        return;
      }

      // 3. Obtener el nuevo CSRF token de la sesión autenticada
      const freshRes  = await fetch('/csrf-token', { headers: { Accept: 'application/json' } });
      const { token: freshToken } = await freshRes.json();

      // 4. Actualizar el token en el formulario pendiente y enviarlo
      if (pendingForm) {
        const tokenInput = pendingForm.querySelector('input[name="_token"]');
        if (tokenInput) tokenInput.value = freshToken;
        const formToSubmit = pendingForm; // guardar antes de que hideModal() lo nullifique
        hideModal();
        formToSubmit.submit();
      }

    } catch (err) {
      showError('Error de conexión. Intentá de nuevo.');
      setLoading(false);
    }
  }

  document.getElementById('btn-relogin').addEventListener('click', doLogin);

  // ── Interceptor global de formularios ──
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
      if (form.action && form.action.includes('/logout')) return;

      form.addEventListener('submit', async function (e) {
        e.preventDefault();

        try {
          const res = await fetch('/ping', { headers: { Accept: 'application/json' } });
          if (res.ok) { form.submit(); return; }
        } catch (_) {
          form.submit(); return; // sin red → dejar pasar
        }

        showModal(form);
      });
    });
  });
})();
</script>
