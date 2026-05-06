<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// AuthController maneja el ciclo de vida de la sesión del usuario.
// Laravel trae un sistema de autenticación basado en sesiones de PHP,
// pero envuelto en una capa más limpia. Auth::attempt() verifica las
// credenciales contra la tabla `users` (usando bcrypt en la columna password),
// y si son correctas arranca la sesión del usuario.
class AuthController extends Controller
{
    // Muestra el formulario de login.
    // Si el usuario ya está logueado lo manda directo al dashboard.
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    // Procesa el intento de login.
    public function login(Request $request)
    {
        // validate() lanza una excepción si los campos no pasan la validación,
        // y Laravel automáticamente redirige de vuelta con los errores.
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt() hace dos cosas:
        //   1. Busca en `users` por email
        //   2. Compara la password ingresada con el hash guardado (bcrypt)
        // El segundo parámetro (boolean) activa la cookie "recuérdame":
        // si es true, la sesión dura semanas; si es false, solo la pestaña.
        $remember = $request->boolean('remember');

        $isAjax = $request->wantsJson();

        // Modo debug: login rápido comparando contra contrasenia_dev (texto plano).
        // Permite usar contraseñas simples de prueba sin tocar el hash de producción.
        if (config('app.debug')) {
            $user = User::where('email', $request->email)->first();
            if ($user && $user->contrasenia_dev === $request->password) {
                Auth::login($user, $remember);
                $request->session()->regenerate();
                if ($isAjax) return response()->json(['ok' => true]);
                return redirect()->intended(route('dashboard'));
            }
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            if ($isAjax) return response()->json(['ok' => true]);
            return redirect()->intended(route('dashboard'));
        }

        if ($isAjax) {
            return response()->json(['error' => 'El email o la contraseña son incorrectos.'], 422);
        }

        return back()
            ->withErrors(['email' => 'El email o la contraseña son incorrectos.'])
            ->onlyInput('email');
    }

    // Cierra la sesión del usuario.
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida la sesión actual (borra todos los datos de sesión del servidor)
        $request->session()->invalidate();

        // Regenera el token CSRF para que el token viejo no sea reutilizable
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
