<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // Notification Preferences
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('push_notifications')->default(true);

            // Specific Notification Types
            $table->boolean('notify_payment_received')->default(true);
            $table->boolean('notify_payment_confirmed')->default(true);
            $table->boolean('notify_tour_completed')->default(true);
            $table->boolean('notify_constellation_filled')->default(true);
            $table->boolean('notify_payout_processed')->default(true);
            $table->boolean('notify_referral_bonus')->default(true);
            $table->boolean('notify_marketing')->default(false);

            // Localization
            $table->string('language', 5)->default('fr'); // fr, en, de, it
            $table->string('timezone')->default('Europe/Zurich');
            $table->string('currency')->default('EUR');
            $table->string('date_format')->default('d/m/Y');

            // Privacy Settings
            $table->boolean('profile_public')->default(false);
            $table->boolean('show_earnings')->default(false);
            $table->boolean('show_referrals')->default(false);

            // UI Preferences
            $table->string('theme')->default('cosmic'); // cosmic, light, dark
            $table->boolean('animations_enabled')->default(true);
            $table->boolean('confetti_enabled')->default(true);

            $table->timestamps();

            // Index
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
