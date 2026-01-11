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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Payment Method Details
            $table->enum('type', ['card', 'bank_transfer', 'paypal', 'mobile_money', 'crypto'])->default('card');
            $table->string('provider')->nullable(); // stripe, paypal, mpesa, etc.
            $table->string('provider_payment_method_id')->nullable(); // External ID from payment provider

            // Card Information (last 4 digits only)
            $table->string('card_brand')->nullable(); // visa, mastercard, amex
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_exp_month', 2)->nullable();
            $table->string('card_exp_year', 4)->nullable();

            // Bank Transfer Information
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic_swift')->nullable();

            // Mobile Money Information
            $table->string('mobile_money_provider')->nullable(); // mpesa, orange_money, mtn_money
            $table->string('mobile_number')->nullable();

            // Crypto Information
            $table->string('crypto_currency')->nullable(); // BTC, ETH, USDT
            $table->string('crypto_wallet_address')->nullable();

            // Additional Details (encrypted JSON)
            $table->text('encrypted_details')->nullable(); // Encrypted sensitive information

            // Status & Defaults
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index(['user_id', 'is_default']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
