<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateCloudinaryImages extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Vérifier si la réponse contient du contenu
        if ($response->getStatusCode() === 200) {
            // Vous pouvez ajouter une logique supplémentaire ici si nécessaire
            // Par exemple, pour valider les URLs Cloudinary dans les contenus
        }
        
        return $response;
    }
}
