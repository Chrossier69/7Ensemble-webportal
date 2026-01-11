<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des passerelles de paiement supportées par 7 Ensemble.
    | Stripe, PayPal, virements bancaires, mobile money et crypto-monnaies.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | La passerelle de paiement par défaut utilisée pour le traitement.
    |
    */

    'default_gateway' => env('DEFAULT_PAYMENT_GATEWAY', 'stripe'),

    /*
    |--------------------------------------------------------------------------
    | Supported Payment Methods
    |--------------------------------------------------------------------------
    |
    | Liste des méthodes de paiement activées sur la plateforme.
    |
    */

    'supported_methods' => [
        'card' => [
            'name' => 'Carte Bancaire',
            'enabled' => true,
            'icon' => 'credit-card',
            'gateway' => 'stripe',
            'description' => 'Visa, Mastercard, American Express',
        ],
        'paypal' => [
            'name' => 'PayPal',
            'enabled' => true,
            'icon' => 'paypal',
            'gateway' => 'paypal',
            'description' => 'Paiement sécurisé via PayPal',
        ],
        'bank_transfer' => [
            'name' => 'Virement Bancaire',
            'enabled' => true,
            'icon' => 'bank',
            'gateway' => 'manual',
            'description' => 'Virement SEPA ou international',
            'manual_verification' => true,
        ],
        'mobile_money' => [
            'name' => 'Mobile Money',
            'enabled' => true,
            'icon' => 'mobile',
            'gateway' => 'mobile_money',
            'description' => 'M-Pesa, Orange Money, MTN Money',
            'regions' => ['africa'],
        ],
        'crypto' => [
            'name' => 'Crypto-monnaie',
            'enabled' => false, // Disabled by default
            'icon' => 'bitcoin',
            'gateway' => 'crypto',
            'description' => 'Bitcoin, Ethereum, USDT',
            'manual_verification' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour Stripe payment gateway.
    |
    */

    'stripe' => [
        'public_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'currency' => 'eur',
        'payment_methods' => ['card'],
        'capture_method' => 'automatic',
        'statement_descriptor' => '7ENSEMBLE',
        'receipt_email' => true,
        'save_payment_method' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | PayPal Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour PayPal payment gateway.
    |
    */

    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
        'sandbox' => [
            'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
            'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        ],
        'live' => [
            'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
            'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
        ],
        'currency' => 'EUR',
        'notify_url' => env('APP_URL') . '/webhooks/paypal',
        'return_url' => env('APP_URL') . '/payment/success',
        'cancel_url' => env('APP_URL') . '/payment/cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Bank Transfer Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour les virements bancaires manuels.
    |
    */

    'bank_transfer' => [
        'enabled' => true,
        'manual_verification' => true,
        'verification_timeout_hours' => 72,
        'bank_details' => [
            'bank_name' => '7 Ensemble Bank Account',
            'account_holder' => '7 Ensemble SARL',
            'iban' => 'CH00 0000 0000 0000 0000 0', // Replace with actual IBAN
            'bic' => 'XXXXCHZZ', // Replace with actual BIC
            'reference_format' => '7E-{user_id}-{transaction_id}',
        ],
        'supported_countries' => ['CH', 'FR', 'BE', 'DE', 'IT', 'ES', 'PT'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Mobile Money Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour Mobile Money (Afrique).
    |
    */

    'mobile_money' => [
        'enabled' => true,
        'api_key' => env('MOBILE_MONEY_API_KEY'),
        'api_secret' => env('MOBILE_MONEY_API_SECRET'),
        'providers' => [
            'mpesa' => [
                'name' => 'M-Pesa',
                'enabled' => true,
                'countries' => ['KE', 'TZ', 'UG'],
            ],
            'orange_money' => [
                'name' => 'Orange Money',
                'enabled' => true,
                'countries' => ['CI', 'SN', 'ML', 'CM'],
            ],
            'mtn_money' => [
                'name' => 'MTN Money',
                'enabled' => true,
                'countries' => ['GH', 'UG', 'RW', 'ZM'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cryptocurrency Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour les paiements en crypto-monnaie.
    |
    */

    'crypto' => [
        'enabled' => false,
        'api_key' => env('CRYPTO_API_KEY'),
        'wallet_address' => env('CRYPTO_WALLET_ADDRESS'),
        'supported_currencies' => [
            'BTC' => 'Bitcoin',
            'ETH' => 'Ethereum',
            'USDT' => 'Tether USD',
            'USDC' => 'USD Coin',
        ],
        'confirmation_blocks' => 3,
        'manual_verification' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des webhooks pour les notifications de paiement.
    |
    */

    'webhooks' => [
        'stripe' => [
            'enabled' => true,
            'path' => '/webhooks/stripe',
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'events' => [
                'payment_intent.succeeded',
                'payment_intent.payment_failed',
                'charge.refunded',
            ],
        ],
        'paypal' => [
            'enabled' => true,
            'path' => '/webhooks/paypal',
            'events' => [
                'PAYMENT.CAPTURE.COMPLETED',
                'PAYMENT.CAPTURE.DENIED',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Processing Settings
    |--------------------------------------------------------------------------
    |
    | Configuration générale du traitement des paiements.
    |
    */

    'processing' => [
        'queue_payments' => true,
        'retry_failed_payments' => true,
        'max_retry_attempts' => 3,
        'retry_delay_minutes' => 30,
        'auto_refund_failed' => false,
        'notification_on_success' => true,
        'notification_on_failure' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Fee Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des frais de transaction.
    |
    */

    'fees' => [
        'admin_percentage' => env('ADMIN_FEE_PERCENTAGE', 5.00),
        'stripe_percentage' => 2.9,
        'stripe_fixed_fee' => 0.30,
        'paypal_percentage' => 3.4,
        'paypal_fixed_fee' => 0.35,
        'calculate_on_total' => true,
        'show_to_user' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Payout Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des paiements sortants vers les utilisateurs.
    |
    */

    'payouts' => [
        'enabled' => true,
        'auto_process' => true,
        'processing_delay_hours' => 24,
        'minimum_amount' => 10.00,
        'maximum_amount' => 100000.00,
        'batch_processing' => true,
        'batch_size' => 50,
        'require_verification' => true,
        'supported_methods' => [
            'bank_transfer',
            'paypal',
            'mobile_money',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security & Fraud Prevention
    |--------------------------------------------------------------------------
    |
    | Configuration de la sécurité et prévention de la fraude.
    |
    */

    'security' => [
        'verify_user_identity' => true,
        'max_daily_transactions' => 10,
        'max_daily_amount' => 5000.00,
        'flag_suspicious_activity' => true,
        'require_3d_secure' => true,
        'ip_geolocation_check' => true,
        'duplicate_transaction_window' => 300, // seconds
        'blacklist_enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Refund Policy
    |--------------------------------------------------------------------------
    |
    | Configuration de la politique de remboursement.
    |
    */

    'refunds' => [
        'enabled' => true,
        'auto_approve' => false,
        'max_days_after_payment' => 14,
        'admin_approval_required' => true,
        'partial_refunds_allowed' => true,
        'refund_fee_deduction' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Test Mode
    |--------------------------------------------------------------------------
    |
    | Active le mode test pour les paiements (sandbox).
    |
    */

    'test_mode' => env('PAYMENT_TEST_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Configuration de l'enregistrement des transactions.
    |
    */

    'logging' => [
        'log_all_transactions' => true,
        'log_webhooks' => true,
        'log_failed_payments' => true,
        'retention_days' => 365,
    ],

];
