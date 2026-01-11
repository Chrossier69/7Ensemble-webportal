<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes - Filament Admin Panel
|--------------------------------------------------------------------------
|
| Ces routes sont gérées automatiquement par Filament.
| Le panneau d'administration est accessible à /admin
|
| Filament gère automatiquement:
| - Authentification admin
| - CRUD pour toutes les ressources
| - Dashboard avec widgets
| - Gestion des utilisateurs
| - Rapports et statistiques
|
| Configuration dans: app/Filament/
|
*/

/*
 * Note: Filament auto-registers its routes.
 * You don't need to manually define routes here.
 *
 * Filament routes are configured in:
 * - config/filament.php
 * - app/Providers/Filament/AdminPanelProvider.php
 *
 * Default admin panel URL: /admin
 *
 * To customize the admin path, update config/filament.php:
 * 'path' => env('FILAMENT_PATH', 'admin'),
 */

/*
|--------------------------------------------------------------------------
| Custom Admin Routes (if needed)
|--------------------------------------------------------------------------
|
| Add custom admin routes here if you need functionality
| outside of Filament's auto-generated routes.
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Custom admin dashboard routes (if not using Filament for these)
    // Route::get('/custom-report', [AdminController::class, 'customReport'])->name('custom-report');

    // Custom admin actions
    // Route::post('/bulk-actions/approve-users', [AdminController::class, 'bulkApproveUsers'])->name('bulk.approve');

});

/*
|--------------------------------------------------------------------------
| Admin API Routes (for AJAX in admin panel)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin/api')->name('admin.api.')->group(function () {

    // Real-time statistics
    // Route::get('/stats/users', [AdminApiController::class, 'userStats'])->name('stats.users');
    // Route::get('/stats/revenue', [AdminApiController::class, 'revenueStats'])->name('stats.revenue');
    // Route::get('/stats/constellations', [AdminApiController::class, 'constellationStats'])->name('stats.constellations');

});

/*
|--------------------------------------------------------------------------
| Notes for Filament Resources
|--------------------------------------------------------------------------
|
| Create Filament resources with:
| php artisan make:filament-resource User --generate
|
| This will create:
| - app/Filament/Resources/UserResource.php
| - app/Filament/Resources/UserResource/Pages/
|
| Available Filament resources to create:
| 1. UserResource - Manage users
| 2. ConstellationResource - Manage constellations
| 3. TransactionResource - Manage transactions
| 4. TourResource - Manage tours
| 5. ReferralResource - Manage referrals
| 6. PaymentMethodResource - Manage payment methods
|
| Create widgets with:
| php artisan make:filament-widget StatsOverview --stats-overview
| php artisan make:filament-widget RevenueChart --chart
|
*/
