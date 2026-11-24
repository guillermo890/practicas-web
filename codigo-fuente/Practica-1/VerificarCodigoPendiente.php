<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCodigoPendiente
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            !session()->has('admin_pendiente') ||
            !session()->has('codigo_verificacion') ||
            !session()->has('codigo_expira')
        ) {
            return redirect()->route('login');
        }

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

        return $next($request);
    }
}
