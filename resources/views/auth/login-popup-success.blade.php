<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Sesión iniciada</title>
<style>
  body { margin: 0; background: #0f1117; color: #e8eaf0; font-family: 'DM Sans', sans-serif;
         display: flex; align-items: center; justify-content: center; height: 100vh; }
  p { font-size: 14px; color: #7c8496; }
</style>
</head>
<body>
<p>Sesión iniciada. Cerrando...</p>
<script>
  if (window.opener) {
    window.opener.postMessage({ type: 'login_success' }, window.location.origin);
  }
  window.close();
</script>
</body>
</html>
