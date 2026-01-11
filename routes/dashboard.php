<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ConstellationController;
use App\Http\Controllers\Dashboard\TourController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\TransferController;
use App\Http\Controllers\Dashboard\ReferralController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\NotificationController;

/*
|--------------------------------------------------------------------------
| Dashboard Routes - Protected User Routes
|--------------------------------------------------------------------------
|
| Routes pour le tableau de bord utilisateur.
| Toutes ces routes nécessitent une authentification.
|
*/

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {

    // ================================================
    // MAIN DASHBOARD
    // ================================================

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/overview', [DashboardController::class, 'overview'])->name('overview');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('stats');

    // ================================================
    // CONSTELLATION MANAGEMENT
    // ================================================

    Route::prefix('constellation')->name('constellation.')->group(function () {
        // View current constellation
        Route::get('/', [ConstellationController::class, 'index'])->name('index');
        Route::get('/my-constellation', [ConstellationController::class, 'show'])->name('show');

        // Constellation details
        Route::get('/members', [ConstellationController::class, 'members'])->name('members');
        Route::get('/history', [ConstellationController::class, 'history'])->name('history');

        // Constellation actions (if user doesn't have one)
        Route::get('/join/{type}', [ConstellationController::class, 'join'])->name('join');
        Route::post('/create', [ConstellationController::class, 'create'])->name('create');

        // Invite members
        Route::get('/invite', [ConstellationController::class, 'invite'])->name('invite');
        Route::post('/send-invite', [ConstellationController::class, 'sendInvite'])->name('send-invite');
    });

    // ================================================
    // TOUR MANAGEMENT
    // ================================================

    Route::prefix('tours')->name('tours.')->group(function () {
        // Tour overview
        Route::get('/', [TourController::class, 'index'])->name('index');
        Route::get('/progress', [TourController::class, 'progress'])->name('progress');

        // Current tour
        Route::get('/current', [TourController::class, 'current'])->name('current');
        Route::get('/tour/{number}', [TourController::class, 'show'])->name('show');

        // Tour progression
        Route::post('/advance', [TourController::class, 'advance'])->name('advance');
        Route::get('/timeline', [TourController::class, 'timeline'])->name('timeline');
    });

    // ================================================
    // PAYMENT MANAGEMENT
    // ================================================

    Route::prefix('payments')->name('payments.')->group(function () {
        // Payment history
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/history', [PaymentController::class, 'history'])->name('history');

        // Individual payment
        Route::get('/transaction/{id}', [PaymentController::class, 'show'])->name('show');
        Route::get('/receipt/{id}', [PaymentController::class, 'receipt'])->name('receipt');
        Route::get('/download/{id}', [PaymentController::class, 'download'])->name('download');

        // Make payment
        Route::get('/make-payment', [PaymentController::class, 'create'])->name('create');
        Route::post('/process', [PaymentController::class, 'process'])->name('process');

        // Payment methods
        Route::get('/methods', [PaymentController::class, 'methods'])->name('methods');
        Route::post('/methods/add', [PaymentController::class, 'addMethod'])->name('methods.add');
        Route::delete('/methods/{id}', [PaymentController::class, 'removeMethod'])->name('methods.remove');
    });

    // ================================================
    // EARNINGS & TRANSFERS
    // ================================================

    Route::prefix('transfers')->name('transfers.')->group(function () {
        // Earnings overview
        Route::get('/', [TransferController::class, 'index'])->name('index');
        Route::get('/earnings', [TransferController::class, 'earnings'])->name('earnings');

        // Withdraw/transfer money
        Route::get('/withdraw', [TransferController::class, 'withdraw'])->name('withdraw');
        Route::post('/withdraw', [TransferController::class, 'processWithdrawal'])->name('withdraw.process');

        // Transfer history
        Route::get('/history', [TransferController::class, 'history'])->name('history');
        Route::get('/pending', [TransferController::class, 'pending'])->name('pending');

        // Bank account management
        Route::get('/accounts', [TransferController::class, 'accounts'])->name('accounts');
        Route::post('/accounts/add', [TransferController::class, 'addAccount'])->name('accounts.add');
        Route::put('/accounts/{id}', [TransferController::class, 'updateAccount'])->name('accounts.update');
        Route::delete('/accounts/{id}', [TransferController::class, 'deleteAccount'])->name('accounts.delete');
    });

    // ================================================
    // REFERRAL SYSTEM
    // ================================================

    Route::prefix('referrals')->name('referrals.')->group(function () {
        // Referral dashboard
        Route::get('/', [ReferralController::class, 'index'])->name('index');
        Route::get('/stats', [ReferralController::class, 'stats'])->name('stats');

        // Referral code
        Route::get('/my-code', [ReferralController::class, 'myCode'])->name('my-code');
        Route::post('/generate-code', [ReferralController::class, 'generateCode'])->name('generate');

        // Referral list
        Route::get('/list', [ReferralController::class, 'list'])->name('list');
        Route::get('/tree', [ReferralController::class, 'tree'])->name('tree');

        // Referral earnings
        Route::get('/earnings', [ReferralController::class, 'earnings'])->name('earnings');

        // Share tools
        Route::get('/share', [ReferralController::class, 'share'])->name('share');
    });

    // ================================================
    // NOTIFICATIONS
    // ================================================

    Route::prefix('notifications')->name('notifications.')->group(function () {
        // View notifications
        Route::get('/', [NotificationController::class, 'index'])->name('index');

        // Mark as read
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');

        // Delete notification
        Route::delete('/{id}', [NotificationController::class, 'delete'])->name('delete');
    });

    // ================================================
    // USER SETTINGS
    // ================================================

    Route::prefix('settings')->name('settings.')->group(function () {
        // General settings
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        // Profile
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::post('/avatar', [SettingsController::class, 'updateAvatar'])->name('avatar.update');

        // Security
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        Route::post('/2fa/enable', [SettingsController::class, 'enable2FA'])->name('2fa.enable');
        Route::post('/2fa/disable', [SettingsController::class, 'disable2FA'])->name('2fa.disable');

        // Notifications preferences
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');

        // Privacy
        Route::get('/privacy', [SettingsController::class, 'privacy'])->name('privacy');
        Route::put('/privacy', [SettingsController::class, 'updatePrivacy'])->name('privacy.update');

        // Account deletion
        Route::get('/delete-account', [SettingsController::class, 'deleteAccount'])->name('delete-account');
        Route::delete('/delete-account', [SettingsController::class, 'confirmDelete'])->name('delete-account.confirm');
    });

    // ================================================
    // SUPPORT & HELP
    // ================================================

    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [DashboardController::class, 'support'])->name('index');
        Route::get('/tickets', [DashboardController::class, 'tickets'])->name('tickets');
        Route::post('/tickets/create', [DashboardController::class, 'createTicket'])->name('tickets.create');
        Route::get('/tickets/{id}', [DashboardController::class, 'showTicket'])->name('tickets.show');
    });

    // ================================================
    // REPORTS & EXPORTS
    // ================================================

    Route::prefix('reports')->name('reports.')->group(function () {
        // Generate reports
        Route::get('/', [DashboardController::class, 'reports'])->name('index');

        // Export data
        Route::get('/export/payments', [PaymentController::class, 'exportPayments'])->name('export.payments');
        Route::get('/export/transactions', [TransferController::class, 'exportTransactions'])->name('export.transactions');
        Route::get('/export/referrals', [ReferralController::class, 'exportReferrals'])->name('export.referrals');

        // PDF reports
        Route::get('/pdf/statement', [DashboardController::class, 'statementPDF'])->name('pdf.statement');
    });

});
