<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $user = Auth::user();

        // Vérifie si l'utilisateur est connecté et si id_role = 1 (admin)
        if (!$user || $user->id_role != 2) {
            return redirect('/')->with('error', 'Vous devez être administrateur pour accéder à cette page.');
        }
        return $next($request);
    }
}
