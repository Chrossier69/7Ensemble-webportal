<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 7 Ensemble Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration spécifique pour le système de constellations 7 Ensemble.
    | Ce fichier contient les paramètres pour les deux types de constellations,
    | les tours, les paiements et les récompenses.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Types de Constellations
    |--------------------------------------------------------------------------
    |
    | Configuration des deux types de constellations disponibles:
    | - Triangulum (3 personnes)
    | - Les Pléiades (7 personnes)
    |
    */

    'constellations' => [
        'triangulum' => [
            'name' => 'Triangulum',
            'size' => env('CONSTELLATION_TRIANGULUM_SIZE', 3),
            'total_earning' => 7789, // Total earnings in EUR
            'description' => 'Constellation de 3 personnes - Gagnez 7,789€',
            'enabled' => true,
        ],
        'pleiades' => [
            'name' => 'Les Pléiades',
            'size' => env('CONSTELLATION_PLEIADES_SIZE', 7),
            'total_earning' => 1575747, // Total earnings in EUR
            'description' => 'Constellation de 7 personnes - Gagnez 1,575,747€',
            'enabled' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration des Tours
    |--------------------------------------------------------------------------
    |
    | Définition des 7 tours avec les montants offerts et reçus pour chaque
    | type de constellation. Les montants sont en EUR.
    |
    */

    'tours' => [
        // Configuration Triangulum (3 personnes)
        'triangulum' => [
            1 => ['offered' => 21, 'received' => 42, 'next' => 42, 'balance' => 21],
            2 => ['offered' => 42, 'received' => 84, 'next' => 84, 'balance' => 63],
            3 => ['offered' => 84, 'received' => 168, 'next' => 168, 'balance' => 147],
            4 => ['offered' => 168, 'received' => 336, 'next' => 336, 'balance' => 315],
            5 => ['offered' => 336, 'received' => 672, 'next' => 672, 'balance' => 651],
            6 => ['offered' => 672, 'received' => 1344, 'next' => 1344, 'balance' => 1323],
            7 => ['offered' => 1344, 'received' => 2688, 'next' => 0, 'balance' => 2667],
            // Total Triangulum: 7,789€
        ],

        // Configuration Les Pléiades (7 personnes)
        'pleiades' => [
            1 => ['offered' => 21, 'received' => 147, 'next' => 147, 'balance' => 126],
            2 => ['offered' => 147, 'received' => 1029, 'next' => 1029, 'balance' => 1008],
            3 => ['offered' => 1029, 'received' => 7203, 'next' => 7203, 'balance' => 7182],
            4 => ['offered' => 7203, 'received' => 50421, 'next' => 50421, 'balance' => 50400],
            5 => ['offered' => 50421, 'received' => 352947, 'next' => 352947, 'balance' => 352926],
            6 => ['offered' => 352947, 'received' => 2470629, 'next' => 2470629, 'balance' => 2470608],
            7 => ['offered' => 2470629, 'received' => 17294403, 'next' => 0, 'balance' => 17294382],
            // Note: Values adjusted for practical implementation
            // Real total would be higher, this is a simplified version
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Paramètres de Paiement
    |--------------------------------------------------------------------------
    |
    | Configuration des paiements initiaux et des frais administratifs.
    |
    */

    'payment' => [
        'initial_amount' => env('INITIAL_PAYMENT_AMOUNT', 21.00),
        'currency' => 'EUR',
        'admin_fee_percentage' => env('ADMIN_FEE_PERCENTAGE', 5.00),
        'timeout_hours' => env('PAYMENT_TIMEOUT_HOURS', 48),
        'max_pending' => env('MAX_PENDING_PAYMENTS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Système de Parrainage
    |--------------------------------------------------------------------------
    |
    | Configuration des bonus de parrainage et des récompenses.
    |
    */

    'referral' => [
        'enabled' => env('REFERRAL_BONUS_ENABLED', true),
        'bonus_amount' => env('REFERRAL_BONUS_AMOUNT', 10.00),
        'bonus_percentage' => env('REFERRAL_BONUS_PERCENTAGE', 5.00),
        'max_bonus_per_referral' => 50.00,
        'track_levels' => 3, // Track up to 3 levels of referrals
    ],

    /*
    |--------------------------------------------------------------------------
    | Rôles dans les Constellations
    |--------------------------------------------------------------------------
    |
    | Définition des rôles au sein d'une constellation.
    |
    */

    'roles' => [
        'alcyone' => [
            'name' => 'Alcyone',
            'description' => 'Receveur - La personne au centre qui reçoit les paiements',
            'icon' => '⭐',
        ],
        'member' => [
            'name' => 'Membre de la Constellation',
            'description' => 'Participant qui soutient l\'Alcyone',
            'icon' => '✨',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Automatisation
    |--------------------------------------------------------------------------
    |
    | Configuration des fonctionnalités automatiques du système.
    |
    */

    'automation' => [
        'auto_assign_constellation' => env('CONSTELLATION_AUTO_ASSIGNMENT', true),
        'auto_tour_progression' => env('TOUR_AUTO_PROGRESSION', true),
        'auto_payout_processing' => true,
        'notification_on_constellation_fill' => env('CONSTELLATION_FILL_NOTIFICATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Limites et Sécurité
    |--------------------------------------------------------------------------
    |
    | Configuration des limites de sécurité et de protection.
    |
    */

    'security' => [
        'max_constellations_per_user' => 1, // User can only be in one active constellation
        'require_email_verification' => env('EMAIL_VERIFICATION_REQUIRED', true),
        'require_payment_verification' => true,
        'fraud_detection_enabled' => true,
        'duplicate_payment_check' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | Types de notifications envoyées aux utilisateurs.
    |
    */

    'notifications' => [
        'welcome' => true,
        'payment_received' => true,
        'payment_confirmed' => true,
        'tour_completed' => true,
        'constellation_filled' => true,
        'payout_processed' => true,
        'referral_bonus' => true,
        'admin_alerts' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Affichage et UI
    |--------------------------------------------------------------------------
    |
    | Configuration de l'interface utilisateur.
    |
    */

    'ui' => [
        'language' => 'fr',
        'currency_symbol' => '€',
        'date_format' => 'd/m/Y',
        'time_format' => 'H:i',
        'items_per_page' => 15,
        'show_cosmic_theme' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Statuts des Transactions
    |--------------------------------------------------------------------------
    |
    | Statuts possibles pour les transactions.
    |
    */

    'transaction_statuses' => [
        'pending' => 'En attente',
        'processing' => 'En cours de traitement',
        'completed' => 'Terminée',
        'failed' => 'Échouée',
        'refunded' => 'Remboursée',
        'cancelled' => 'Annulée',
    ],

    /*
    |--------------------------------------------------------------------------
    | Statuts des Constellations
    |--------------------------------------------------------------------------
    |
    | Statuts possibles pour les constellations.
    |
    */

    'constellation_statuses' => [
        'forming' => 'En formation',
        'active' => 'Active',
        'completed' => 'Terminée',
        'disbanded' => 'Dissoute',
    ],

];
