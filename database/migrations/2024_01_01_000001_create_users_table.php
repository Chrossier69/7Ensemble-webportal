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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Profile Information
            $table->string('phone', 20)->nullable();
            $table->string('country', 2)->default('FR'); // ISO country code
            $table->string('avatar_url')->nullable();
            $table->date('date_of_birth')->nullable();

            // Constellation & Tour Progress
            $table->foreignId('constellation_id')->nullable()->constrained('constellations')->nullOnDelete();
            $table->unsignedTinyInteger('current_tour')->default(1); // 1-7
            $table->string('constellation_type')->nullable(); // triangulum or pleiades
            $table->boolean('is_alcyone')->default(false); // Is user center of constellation

            // Referral System
            $table->string('referral_code', 20)->unique();
            $table->foreignId('referred_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('referral_earnings', 10, 2)->default(0);

            // Financial Tracking
            $table->decimal('total_paid', 10, 2)->default(0); // Total amount paid
            $table->decimal('total_received', 10, 2)->default(0); // Total amount received
            $table->decimal('total_earnings', 10, 2)->default(0); // Net earnings (received - paid)
            $table->decimal('available_balance', 10, 2)->default(0); // Available for withdrawal

            // Payment & Verification
            $table->boolean('has_paid_initial')->default(false);
            $table->timestamp('initial_payment_at')->nullable();
            $table->boolean('payment_verified')->default(false);

            // User Status & Role
            $table->enum('status', ['active', 'suspended', 'banned', 'pending_verification'])->default('active');
            $table->enum('role', ['user', 'admin', 'moderator'])->default('user');

            // Preferences (JSON)
            $table->json('preferences')->nullable(); // Notifications, language, timezone
            $table->json('kyc_data')->nullable(); // KYC verification data

            // Security
            $table->string('two_factor_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('referral_code');
            $table->index('constellation_id');
            $table->index('referred_by_id');
            $table->index('status');
            $table->index('role');
            $table->index(['email', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
