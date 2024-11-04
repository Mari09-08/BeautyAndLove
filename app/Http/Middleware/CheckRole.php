<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }
    
        $user = Auth::user();
    
        // Si el usuario ya está en la ruta que le corresponde, no redirigir de nuevo
        if ($user->rol == 1 && !$request->is('dashboard')) {
            // return redirect()->route('dashboard');
            return $next($request);
        } elseif ($user->rol == 2 && !$request->is('profesional.dashboard')) {
            // return redirect()->route('profesional.dashboard');
            return $next($request);
        } elseif ($user->rol == 3 && !$request->is('/')) {
            // return redirect()->route('home');
        return $next($request);

        }
    
        // Si ya está en la ruta correspondiente, continuar
        return $next($request);
    }
}
