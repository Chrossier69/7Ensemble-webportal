<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Services\ConstellationService;
use App\Services\TourService;
use App\Services\PayoutService;

/**
 * ConstellationServiceProvider
 *
 * Service provider pour gérer les constellations et leurs fonctionnalités.
 * Enregistre les services, les directives Blade, et les view composers.
 */
class ConstellationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Enregistrer ConstellationService comme singleton
        $this->app->singleton(ConstellationService::class, function ($app) {
            return new ConstellationService();
        });

        // Enregistrer TourService comme singleton
        $this->app->singleton(TourService::class, function ($app) {
            return new TourService();
        });

        // Enregistrer PayoutService comme singleton
        $this->app->singleton(PayoutService::class, function ($app) {
            return new PayoutService();
        });

        // Bind l'interface au service (si vous utilisez des interfaces)
        // $this->app->bind(ConstellationServiceInterface::class, ConstellationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enregistrer les directives Blade personnalisées
        $this->registerBladeDirectives();

        // Enregistrer les View Composers
        $this->registerViewComposers();

        // Enregistrer les macros
        $this->registerMacros();

        // Publier les fichiers de configuration (si nécessaire)
        $this->publishes([
            __DIR__.'/../../config/7ensemble.php' => config_path('7ensemble.php'),
            __DIR__.'/../../config/payment.php' => config_path('payment.php'),
        ], '7ensemble-config');
    }

    /**
     * Enregistrer les directives Blade personnalisées.
     */
    protected function registerBladeDirectives(): void
    {
        // Directive pour afficher le montant en EUR formaté
        Blade::directive('eur', function ($expression) {
            return "<?php echo number_format($expression, 2, ',', ' ') . ' €'; ?>";
        });

        // Directive pour vérifier si l'utilisateur a une constellation
        Blade::if('hasConstellation', function () {
            return auth()->check() && auth()->user()->constellation_id;
        });

        // Directive pour vérifier si l'utilisateur est Alcyone
        Blade::if('isAlcyone', function () {
            return auth()->check() && auth()->user()->isAlcyone();
        });

        // Directive pour vérifier le type de constellation
        Blade::if('constellationType', function ($type) {
            return auth()->check() &&
                   auth()->user()->constellation &&
                   auth()->user()->constellation->type === $type;
        });

        // Directive pour afficher le statut d'un tour
        Blade::directive('tourStatus', function ($tour) {
            return "<?php echo \App\Helpers\TourHelper::getStatus($tour); ?>";
        });

        // Directive pour afficher le badge de statut
        Blade::directive('statusBadge', function ($status) {
            return "<?php echo \App\Helpers\StatusHelper::badge($status); ?>";
        });

        // Directive pour formater les dates en français
        Blade::directive('dateFR', function ($expression) {
            return "<?php echo ($expression) ? ($expression)->locale('fr')->isoFormat('LL') : 'N/A'; ?>";
        });

        // Directive pour formater les dates avec heure
        Blade::directive('datetimeFR', function ($expression) {
            return "<?php echo ($expression) ? ($expression)->locale('fr')->isoFormat('LLLL') : 'N/A'; ?>";
        });
    }

    /**
     * Enregistrer les View Composers.
     */
    protected function registerViewComposers(): void
    {
        // Partager les données de configuration avec toutes les vues
        View::composer('*', function ($view) {
            $view->with([
                'constellationTypes' => config('7ensemble.constellations'),
                'tourCount' => config('7ensemble.tours.tour_count', 7),
                'currencySymbol' => config('7ensemble.ui.currency_symbol', '€'),
            ]);
        });

        // Partager les données utilisateur avec les vues du dashboard
        View::composer('layouts.dashboard', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $view->with([
                    'userConstellation' => $user->constellation,
                    'currentTour' => $user->current_tour ?? 1,
                    'totalEarnings' => $user->total_earnings ?? 0,
                    'pendingPayments' => $user->pendingPayments()->count(),
                    'unreadNotifications' => $user->unreadNotifications()->count(),
                ]);
            }
        });

        // Partager les statistiques avec le header du dashboard
        View::composer('components.dashboard-header', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $view->with([
                    'userName' => $user->name,
                    'userAvatar' => $user->avatar_url,
                    'notifications' => $user->unreadNotifications()->latest()->take(5)->get(),
                ]);
            }
        });
    }

    /**
     * Enregistrer les macros personnalisées.
     */
    protected function registerMacros(): void
    {
        // Macro pour formater les montants
        \Illuminate\Support\Str::macro('formatEur', function ($amount) {
            return number_format($amount, 2, ',', ' ') . ' €';
        });

        // Macro pour générer un code de référence unique
        \Illuminate\Support\Str::macro('referralCode', function () {
            return '7E-' . strtoupper(\Illuminate\Support\Str::random(8));
        });

        // Macro pour générer un ID de transaction
        \Illuminate\Support\Str::macro('transactionId', function () {
            return 'TXN-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(10));
        });
    }
}
