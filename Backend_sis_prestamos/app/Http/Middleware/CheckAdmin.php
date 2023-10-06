<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Verificar si el usuario autenticado tiene el rol de "Admin"
       if ($request->user() && $request->user()->hasRole('Admin')) {
        return $next($request);
    }

    // El usuario no es un administrador, puedes redirigir o responder con un error aquí
    return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
    }
}
