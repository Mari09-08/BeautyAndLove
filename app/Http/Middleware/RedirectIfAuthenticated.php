<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Excluir rutas públicas como login, register, etc.
        if ($request->is('login') || $request->is('register') || $request->is('logout')) {
            return $next($request);
        }

        // Si no se pasa un guard, usar el por defecto
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user(); // Obtener usuario autenticado
                
                // Redirigir según el rol del usuario
                if ($user->rol == 1) {
                    return redirect()->route('dashboard'); // Redirigir a admin
                } elseif ($user->rol == 2) {
                    return redirect()->route('profesional.dashboard'); // Redirigir a profesional
                } elseif ($user->rol == 3) {
                    return redirect()->route('home'); // Redirigir a cliente o home
                }
            }
        }

        // Continuar si no está autenticado
        return $next($request);
    }
}
