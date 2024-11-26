<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TrabajadoresMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Verificar roles permitidos
        $rolesPermitidos = ['Tapicería', 'Costura', 'Esqueletería', 'Embalaje'];

        if (in_array($user->role, $rolesPermitidos)) {
            // Redirigir a una ruta específica para trabajadores
            return redirect()->route('trabajadores.dashboard');
        }

        return $next($request);
    }
}
