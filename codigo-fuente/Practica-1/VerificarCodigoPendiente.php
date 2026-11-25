<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCodigoPendiente
{
    public function handle(Request $request, Closure $next): Response
    {
        // Comprueba que existan los datos necesarios para verificar al administrador
        if (
            !session()->has('admin_pendiente') ||
            !session()->has('codigo_verificacion') ||
            !session()->has('codigo_expira')
        ) {
            return redirect()->route('login');
        }

        // Comprueba si el código de verificación ya expiró
        if (now()->timestamp > session('codigo_expira')) {
            session()->forget([
                'admin_pendiente',
                'codigo_verificacion',
                'codigo_expira'
            ]);

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'El código expiró. Inicia sesión nuevamente.'
                ]);
        }

        // Si la verificación sigue vigente, permite continuar
        return $next($request);
    }
}
