<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
   
    public function mostrarLogin()
    {
        // Comprueba si ya existe una sesión iniciada
        if (Auth::check()) {
            return redirect()->route('inicio');
        }

        
        return view('auth.login');
    }


    public function iniciarSesion(Request $request)
    {
        // Valida que el correo y la contraseña no estén vacíos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Busca al usuario por su correo electrónico
        $usuario = User::where('email', $request->email)->first();

        // Comprueba que el usuario exista y que la contraseña coincida
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()->withErrors([
                'email' => 'Correo o contraseña incorrectos.'
            ])->withInput();
        }

        // Comprueba que el usuario tenga un rol asignado
        if (!$usuario->role) {
            return back()->withErrors([
                'email' => 'El usuario no tiene un rol asignado.'
            ])->withInput();
        }

        // Si es administrador, solicita una verificación adicional
        if ($usuario->role->nombre == 'Administrador') {

        
            $codigo = random_int(100000, 999999);

            // Guarda los datos necesarios para verificar el código
            session([
                'admin_pendiente' => $usuario->id,
                'codigo_verificacion' => Hash::make((string) $codigo),
                'codigo_expira' => now()->addMinutes(5)->timestamp,
                'intentos_codigo' => 0
            ]);

            // Envía el código al correo del administrador
            Mail::raw(
                "Tu código de verificación es: $codigo. Tiene una duración de 5 minutos.",
                function ($mensaje) use ($usuario) {
                    $mensaje->to($usuario->email)
                        ->subject('Código de verificación');
                }
            );

            return redirect()->route('verificar.codigo');
        }

        // Permite iniciar sesión a empleado, profesor y alumno
        if (in_array($usuario->role->nombre, ['Empleado', 'Profesor', 'Alumno'])) {

            Auth::login($usuario);

            // Regenera la sesión por seguridad
            $request->session()->regenerate();

       
            return redirect()->route('inicio');
        }

        // Muestra un error si el rol no tiene acceso
        return back()->withErrors([
            'email' => 'Tu rol no tiene acceso al inicio de sesión.'
        ]);
    }

    
    public function mostrarVerificacion()
    {
        // Comprueba que exista un administrador pendiente de verificar
        if (!session()->has('admin_pendiente')) {
            return redirect()->route('login');
        }

        return view('auth.verificar');
    }

    public function verificarCodigo(Request $request)
    {
        // Valida que el código tenga exactamente seis dígitos
        $request->validate([
            'codigo' => 'required|digits:6'
        ]);

        // Comprueba que exista una verificación pendiente
        if (!session()->has('admin_pendiente')) {
            return redirect()->route('login');
        }

        // Recupera la cantidad de intentos realizados
        $intentos = session('intentos_codigo', 0);

        // Comprueba si ya se alcanzó el límite de cinco intentos
        if ($intentos >= 5) {
            // Elimina los datos temporales de la verificación
            session()->forget([
                'admin_pendiente',
                'codigo_verificacion',
                'codigo_expira',
                'intentos_codigo'
            ]);

            // Regresa al login mostrando un error
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Superaste los intentos permitidos. Inicia sesión nuevamente.'
                ]);
        }

        // Comprueba si el código ya expiró
        if (now()->timestamp > session('codigo_expira')) {
            // Elimina los datos temporales de la verificación
            session()->forget([
                'admin_pendiente',
                'codigo_verificacion',
                'codigo_expira',
                'intentos_codigo'
            ]);

            // Regresa al login porque el código venció
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'El código expiró. Inicia sesión nuevamente.'
                ]);
        }

        // Compara el código ingresado con el código guardado
        if (!Hash::check($request->codigo, session('codigo_verificacion'))) {

            // Aumenta en uno la cantidad de intentos
            session([
                'intentos_codigo' => $intentos + 1
            ]);

            // Regresa mostrando que el código es incorrecto
            return back()->withErrors([
                'codigo' => 'El código es incorrecto. Intentos restantes: ' . (4 - $intentos)
            ]);
        }

        // Busca al administrador usando el ID guardado en la sesión
        $usuario = User::find(session('admin_pendiente'));

        // Comprueba que el usuario exista y siga teniendo el rol de administrador
        if (!$usuario || !$usuario->role || $usuario->role->nombre != 'Administrador') {
            // Elimina los datos temporales
            session()->forget([
                'admin_pendiente',
                'codigo_verificacion',
                'codigo_expira',
                'intentos_codigo'
            ]);

            return redirect()->route('login');
        }

        // Inicia la sesión del administrador
        Auth::login($usuario);

        // Regenera la sesión por seguridad
        $request->session()->regenerate();

        // Limpia los datos temporales de la verificación
        session()->forget([
            'admin_pendiente',
            'codigo_verificacion',
            'codigo_expira',
            'intentos_codigo'
        ]);

        // Envía al administrador al inicio
        return redirect()->route('inicio');
    }
            
    public function cerrarSesion(Request $request)
    {
        // Cierra la sesión de autenticación
        Auth::logout();

        // Invalida la sesión actual
        $request->session()->invalidate();

        // Genera un nuevo token de seguridad
        $request->session()->regenerateToken();

        // Regresa a la pantalla de login
        return redirect()->route('login');
    }
}
