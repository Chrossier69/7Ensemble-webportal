<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckUserTour Middleware
 *
 * Vérifie que l'utilisateur a accès au tour demandé.
 * Empêche les utilisateurs d'accéder à des tours auxquels ils n'ont pas encore droit.
 */
class CheckUserTour
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si l'utilisateur n'est pas authentifié, rediriger vers login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour continuer.');
        }

        // Vérifier si l'utilisateur a une constellation
        if (!$user->constellation) {
            return redirect()
                ->route('dashboard.constellation.index')
                ->with('error', 'Vous devez rejoindre une constellation pour accéder aux tours.');
        }

        // Récupérer le tour demandé depuis la route
        $requestedTour = $request->route('tour');

        if ($requestedTour) {
            // Récupérer le tour actuel de l'utilisateur
            $currentTour = $user->current_tour ?? 1;

            // Vérifier si l'utilisateur a le droit d'accéder à ce tour
            if ($requestedTour > $currentTour) {
                return redirect()
                    ->route('dashboard.tours.current')
                    ->with('error', "Vous devez d'abord compléter le Tour {$currentTour}.");
            }

            // Vérifier si le tour demandé est valide (1-7)
            if ($requestedTour < 1 || $requestedTour > 7) {
                return redirect()
                    ->route('dashboard.tours.index')
                    ->with('error', 'Numéro de tour invalide.');
            }
        }

        // Vérifier si l'utilisateur a des paiements en attente
        if ($user->hasPendingPayments()) {
            // Ajouter une notification mais permettre l'accès
            session()->flash('warning', 'Vous avez des paiements en attente. Veuillez les compléter pour progresser.');
        }

        return $next($request);
    }
}
