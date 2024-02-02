<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Verificar el tipo de usuario
            $user = Auth::user();

            if ($user->rol_id == $type) {
                return $next($request);
            }
        }

        if(!Auth::check()){
            return response()->json(['error' => 'Acceso no autorizado'], 403);

        }

        // Redireccionar o devolver un error según tus necesidades
        return response()->json(['error' => 'Acceso no autorizado'], 403);
    }
}
