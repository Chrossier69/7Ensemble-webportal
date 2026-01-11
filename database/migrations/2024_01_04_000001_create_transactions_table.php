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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // Custom transaction ID (e.g., TXN-20240109-XXXX)

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tour_id')->nullable()->constrained('tours')->nullOnDelete();
            $table->foreignId('constellation_id')->nullable()->constrained('constellations')->nullOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();

            // Transaction Type
            $table->enum('type', [
                'payment',           // Payment to Alcyone
                'payout',            // Payout from constellation
                'transfer',          // Bank transfer/withdrawal
                'referral_bonus',    // Referral bonus payment
                'admin_fee',         // Administrative fee
                'refund',            // Refund payment
                'initial_payment'    // Initial 21€ payment
            ])->default('payment');

            // Direction
            $table->enum('direction', ['credit', 'debit']); // credit = money in, debit = money out

            // Financial Details
            $table->decimal('amount', 12, 2); // Transaction amount
            $table->string('currency', 3)->default('EUR');
            $table->decimal('fee', 10, 2)->default(0); // Transaction fee
            $table->decimal('net_amount', 12, 2); // Amount after fees

            // Related User (for transfers between users)
            $table->foreignId('related_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('related_user_name')->nullable(); // Name of Alcyone or recipient

            // Payment Gateway Details
            $table->string('payment_gateway')->nullable(); // stripe, paypal, bank, etc.
            $table->string('gateway_transaction_id')->nullable(); // External transaction ID
            $table->string('gateway_reference')->nullable(); // Payment reference
            $table->text('gateway_response')->nullable(); // Raw gateway response (JSON)

            // Status
            $table->enum('status', [
                'pending',      // Waiting for processing
                'processing',   // Being processed
                'completed',    // Successfully completed
                'failed',       // Failed
                'refunded',     // Refunded
                'cancelled',    // Cancelled
                'on_hold'       // On hold for verification
            ])->default('pending');

            // Bank Transfer Details (if applicable)
            $table->string('bank_reference')->nullable();
            $table->string('bank_account')->nullable();

            // Verification
            $table->boolean('requires_verification')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            // Receipts & Documents
            $table->string('receipt_url')->nullable();
            $table->string('proof_of_payment_url')->nullable();

            // Dates
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            // Failure Details
            $table->string('failure_reason')->nullable();
            $table->text('failure_message')->nullable();

            // Notes & Metadata
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            $table->json('metadata')->nullable(); // Additional data

            // IP & Security
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('transaction_id');
            $table->index('user_id');
            $table->index('tour_id');
            $table->index('constellation_id');
            $table->index('type');
            $table->index('status');
            $table->index('payment_gateway');
            $table->index('gateway_transaction_id');
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
