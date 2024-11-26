<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $userRole = Auth::user()->rol;

            // Permitir acceso si el rol coincide con alguno de los especificados
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        // Redirigir si no tiene acceso
        return redirect('/no-autorizado'); // O una página personalizada de error
    }
}