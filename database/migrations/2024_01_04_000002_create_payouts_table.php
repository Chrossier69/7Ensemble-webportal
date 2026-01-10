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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id')->unique(); // Custom payout ID (e.g., PAY-20240109-XXXX)

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tour_id')->nullable()->constrained('tours')->nullOnDelete();
            $table->foreignId('constellation_id')->nullable()->constrained('constellations')->nullOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();

            // Payout Details
            $table->decimal('amount', 12, 2); // Payout amount
            $table->string('currency', 3)->default('EUR');
            $table->decimal('fee', 10, 2)->default(0); // Processing fee
            $table->decimal('net_amount', 12, 2); // Amount after fees

            // Payout Method
            $table->enum('payout_method', ['bank_transfer', 'paypal', 'mobile_money', 'crypto'])->default('bank_transfer');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();

            // Bank Account Details (encrypted or tokenized)
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic_swift')->nullable();
            $table->string('account_number_last4', 4)->nullable(); // Last 4 digits for display

            // PayPal Details
            $table->string('paypal_email')->nullable();

            // Mobile Money Details
            $table->string('mobile_money_provider')->nullable();
            $table->string('mobile_number')->nullable();

            // Crypto Details
            $table->string('crypto_currency')->nullable();
            $table->string('crypto_wallet_address')->nullable();
            $table->string('crypto_transaction_hash')->nullable();

            // Status
            $table->enum('status', [
                'pending',      // Waiting for processing
                'approved',     // Approved, waiting to be sent
                'processing',   // Being processed
                'completed',    // Successfully sent
                'failed',       // Failed to send
                'cancelled',    // Cancelled
                'on_hold'       // On hold for verification
            ])->default('pending');

            // Approval & Processing
            $table->boolean('requires_approval')->default(true);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();

            // Gateway Details
            $table->string('gateway')->nullable(); // stripe, paypal, wise, etc.
            $table->string('gateway_payout_id')->nullable(); // External payout ID
            $table->string('gateway_reference')->nullable();
            $table->text('gateway_response')->nullable();

            // Dates
            $table->timestamp('requested_at'); // When user requested payout
            $table->timestamp('scheduled_for')->nullable(); // Scheduled processing date
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->unsignedInteger('processing_days')->nullable(); // Days taken to process

            // Failure Details
            $table->string('failure_reason')->nullable();
            $table->text('failure_message')->nullable();
            $table->unsignedTinyInteger('retry_count')->default(0);
            $table->timestamp('next_retry_at')->nullable();

            // Documents
            $table->string('receipt_url')->nullable();
            $table->string('proof_of_transfer_url')->nullable();

            // Notes
            $table->text('user_notes')->nullable(); // User's notes about payout
            $table->text('admin_notes')->nullable(); // Admin's internal notes

            // Metadata
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('payout_id');
            $table->index('user_id');
            $table->index('tour_id');
            $table->index('constellation_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('payout_method');
            $table->index(['user_id', 'status']);
            $table->index(['status', 'requested_at']);
            $table->index('scheduled_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
