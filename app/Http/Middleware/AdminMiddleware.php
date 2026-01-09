<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware
 *
 * Vérifie que l'utilisateur est un administrateur.
 * Utilisé pour protéger les routes d'administration.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Vérifier si l'utilisateur est un administrateur
        if (!$user->isAdmin()) {
            abort(403, 'Accès non autorisé. Cette page est réservée aux administrateurs.');
        }

        // Logger l'accès admin (optionnel)
        if (config('app.env') === 'production') {
            \Log::info('Admin access', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'route' => $request->path(),
                'ip' => $request->ip(),
                'timestamp' => now(),
            ]);
        }

        return $next($request);
    }
}
