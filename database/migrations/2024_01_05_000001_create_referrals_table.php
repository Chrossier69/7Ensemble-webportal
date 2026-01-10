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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            // Referrer (Person who referred)
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();

            // Referee (Person who was referred)
            $table->foreignId('referee_id')->constrained('users')->cascadeOnDelete();

            // Referral Level (for multi-level tracking)
            $table->unsignedTinyInteger('level')->default(1); // 1 = direct, 2 = second level, 3 = third level

            // Bonus Details
            $table->decimal('bonus_amount', 10, 2)->default(0); // Bonus earned from this referral
            $table->decimal('bonus_percentage', 5, 2)->default(0); // Percentage earned
            $table->decimal('total_bonus_earned', 10, 2)->default(0); // Total earned from this referral over time

            // Status
            $table->enum('status', [
                'pending',      // Waiting for referee to complete action
                'qualified',    // Referee completed qualifying action
                'paid',         // Bonus paid to referrer
                'expired',      // Referral expired
                'cancelled'     // Referral cancelled
            ])->default('pending');

            // Qualification Tracking
            $table->enum('qualification_type', [
                'registration',          // Bonus for registration only
                'first_payment',         // Bonus after first payment
                'constellation_joined',  // Bonus after joining constellation
                'tour_completed',        // Bonus after tour completion
                'recurring'              // Recurring bonus from referee's activities
            ])->default('first_payment');

            $table->boolean('is_qualified')->default(false);
            $table->timestamp('qualified_at')->nullable();

            // Payment Tracking
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();

            // Referee Progress Tracking
            $table->boolean('referee_registered')->default(true);
            $table->boolean('referee_paid_initial')->default(false);
            $table->boolean('referee_joined_constellation')->default(false);
            $table->unsignedTinyInteger('referee_tours_completed')->default(0);

            // Dates
            $table->timestamp('referred_at'); // When referral was created
            $table->timestamp('expires_at')->nullable(); // Expiration date for qualification

            // Conversion Tracking
            $table->unsignedInteger('days_to_convert')->nullable(); // Days from referral to qualification
            $table->json('conversion_metadata')->nullable(); // Additional conversion tracking data

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Unique constraint - one referral record per referrer-referee pair
            $table->unique(['referrer_id', 'referee_id']);

            // Indexes
            $table->index('referrer_id');
            $table->index('referee_id');
            $table->index('status');
            $table->index('level');
            $table->index('is_qualified');
            $table->index('is_paid');
            $table->index(['referrer_id', 'status']);
            $table->index(['referee_id', 'status']);
            $table->index('qualification_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
