<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureUserHasConstellation Middleware
 *
 * Vérifie que l'utilisateur fait partie d'une constellation.
 * Redirige vers la page de création de constellation si ce n'est pas le cas.
 */
class EnsureUserHasConstellation
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

        // Vérifier si l'utilisateur a une constellation
        if (!$user->constellation_id || !$user->constellation) {
            // Routes autorisées sans constellation
            $allowedRoutes = [
                'dashboard.constellation.index',
                'dashboard.constellation.join',
                'dashboard.constellation.create',
                'dashboard.settings.*',
                'dashboard.support.*',
            ];

            // Vérifier si la route actuelle est dans les routes autorisées
            foreach ($allowedRoutes as $route) {
                if ($request->routeIs($route)) {
                    return $next($request);
                }
            }

            // Rediriger vers la page de création de constellation
            return redirect()
                ->route('dashboard.constellation.index')
                ->with('warning', 'Vous devez rejoindre ou créer une constellation pour accéder à cette fonctionnalité.');
        }

        // Vérifier si la constellation est active
        if ($user->constellation && $user->constellation->status !== 'active') {
            $status = $user->constellation->status;

            $messages = [
                'forming' => 'Votre constellation est en cours de formation. Veuillez patienter.',
                'completed' => 'Votre constellation a été complétée. Félicitations!',
                'disbanded' => 'Votre constellation a été dissoute. Veuillez en rejoindre une nouvelle.',
            ];

            $message = $messages[$status] ?? 'Statut de constellation inconnu.';

            // Si la constellation est dissoute, forcer la création d'une nouvelle
            if ($status === 'disbanded') {
                $user->constellation_id = null;
                $user->save();

                return redirect()
                    ->route('dashboard.constellation.index')
                    ->with('error', $message);
            }

            // Pour les autres statuts, afficher un avertissement mais permettre l'accès
            session()->flash('info', $message);
        }

        // Vérifier si l'utilisateur a payé le montant initial
        if (!$user->hasCompletedInitialPayment()) {
            return redirect()
                ->route('dashboard.payments.create')
                ->with('warning', 'Veuillez effectuer le paiement initial de ' . config('7ensemble.payment.initial_amount') . '€ pour activer votre constellation.');
        }

        return $next($request);
    }
}
