<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Comprueba que el usuario haya iniciado sesión
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Comprueba que el rol del usuario esté entre los roles permitidos
        if (!in_array($request->user()->role->nombre, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Si cumple las condiciones, permite continuar
        return $next($request);
    }
}
