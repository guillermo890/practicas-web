<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar formulario de inicio de sesión
    public function mostrarLogin()
    {
        if (Auth::check()) {
            return redirect()->route('inicio');
        }

        return view('auth.login');
    }

    // Procesar inicio de sesión
    public function iniciarSesion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()->withErrors([
                'email' => 'Correo o contraseña incorrectos.'
            ])->withInput();
        }

        if (!$usuario->role) {
            return back()->withErrors([
                'email' => 'El usuario no tiene un rol asignado.'
            ])->withInput();
        }

        // Verificación adicional para administrador
        if ($usuario->role->nombre == 'Administrador') {

            $codigo = random_int(100000, 999999);

           session([
           'admin_pendiente' => $usuario->id,
            'codigo_verificacion' => Hash::make((string) $codigo),
               'codigo_expira' => now()->addMinutes(5)->timestamp,
                 'intentos_codigo' => 0
                  ]);

            Mail::raw(
                "Tu código de verificación es: $codigo. Tiene una duración de 5 minutos.",
                function ($mensaje) use ($usuario) {
                    $mensaje->to($usuario->email)
                        ->subject('Código de verificación');
                }
            );

            return redirect()->route('verificar.codigo');
        }

        // Inicio de sesión convencional para empleado
        if ($usuario->role->nombre == 'Empleado') {

            Auth::login($usuario);
            $request->session()->regenerate();

            return redirect()->route('inicio');
        }

        return back()->withErrors([
            'email' => 'Tu rol no tiene acceso al inicio de sesión.'
        ]);
    }

    // Mostrar formulario del código
    public function mostrarVerificacion()
    {
        if (!session()->has('admin_pendiente')) {
            return redirect()->route('login');
        }

        return view('auth.verificar');
    }

    // Comprobar código de administrador
    public function verificarCodigo(Request $request)
    {
    $request->validate([
        'codigo' => 'required|digits:6'
    ]);

    if (!session()->has('admin_pendiente')) {
        return redirect()->route('login');
    }

    // Comprobar intentos permitidos
    $intentos = session('intentos_codigo', 0);

    if ($intentos >= 5) {
        session()->forget([
            'admin_pendiente',
            'codigo_verificacion',
            'codigo_expira',
            'intentos_codigo'
        ]);

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Superaste los intentos permitidos. Inicia sesión nuevamente.'
            ]);
    }

    // Comprobar expiración
    if (now()->timestamp > session('codigo_expira')) {
        session()->forget([
            'admin_pendiente',
            'codigo_verificacion',
            'codigo_expira',
            'intentos_codigo'
        ]);

        return redirect()->route('login')
            ->withErrors([
                'email' => 'El código expiró. Inicia sesión nuevamente.'
            ]);
    }

    // Comprobar código
    if (!Hash::check($request->codigo, session('codigo_verificacion'))) {

        session([
            'intentos_codigo' => $intentos + 1
        ]);

        return back()->withErrors([
            'codigo' => 'El código es incorrecto. Intentos restantes: ' . (4 - $intentos)
        ]);
    }

    $usuario = User::find(session('admin_pendiente'));

    if (!$usuario || !$usuario->role || $usuario->role->nombre != 'Administrador') {
        session()->forget([
            'admin_pendiente',
            'codigo_verificacion',
            'codigo_expira',
            'intentos_codigo'
        ]);

        return redirect()->route('login');
    }

    Auth::login($usuario);
    $request->session()->regenerate();

    session()->forget([
        'admin_pendiente',
        'codigo_verificacion',
        'codigo_expira',
        'intentos_codigo'
    ]);

    return redirect()->route('inicio');
}


    // Cerrar sesión
    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
