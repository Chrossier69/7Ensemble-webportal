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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('constellation_id')->constrained('constellations')->cascadeOnDelete();
            $table->foreignId('tour_requirement_id')->nullable()->constrained('tour_requirements')->nullOnDelete();

            // Tour Details
            $table->unsignedTinyInteger('tour_number'); // 1-7
            $table->enum('constellation_type', ['triangulum', 'pleiades']);

            // Financial Details
            $table->decimal('amount_to_pay', 10, 2); // Amount user needs to pay
            $table->decimal('amount_paid', 10, 2)->default(0); // Amount actually paid
            $table->decimal('amount_to_receive', 10, 2); // Amount user will receive
            $table->decimal('amount_received', 10, 2)->default(0); // Amount actually received
            $table->decimal('amount_kept', 10, 2)->default(0); // Net earnings (received - paid)

            // Payment Status
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->timestamp('payment_due_date')->nullable();
            $table->timestamp('payment_completed_at')->nullable();

            // Receipt Status
            $table->enum('receipt_status', ['waiting', 'partial', 'received', 'completed'])->default('waiting');
            $table->timestamp('receipt_expected_date')->nullable();
            $table->timestamp('receipt_completed_at')->nullable();

            // Tour Status
            $table->enum('status', ['pending', 'active', 'in_progress', 'completed', 'failed', 'cancelled'])->default('pending');
            // pending: not started yet
            // active: tour is active, waiting for payments
            // in_progress: payments being processed
            // completed: tour finished successfully
            // failed: tour failed (payment issues, etc.)
            // cancelled: tour cancelled

            // Alcyone (Receiver) for This Tour
            $table->foreignId('alcyone_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_alcyone')->default(false); // Is this user the Alcyone for this tour

            // Progress Tracking
            $table->unsignedTinyInteger('members_paid')->default(0); // Number of members who paid
            $table->unsignedTinyInteger('required_members'); // Required members (3 or 7)

            // Dates
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->unsignedInteger('duration_days')->nullable(); // Days taken to complete

            // Notes & Metadata
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // Additional data

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('constellation_id');
            $table->index('tour_number');
            $table->index('status');
            $table->index('payment_status');
            $table->index('receipt_status');
            $table->index('alcyone_id');
            $table->index(['user_id', 'tour_number']);
            $table->index(['constellation_id', 'tour_number']);
            $table->index(['user_id', 'status']);

            // Unique constraint - one tour per user per tour number
            $table->unique(['user_id', 'constellation_id', 'tour_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
