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
        Schema::create('constellation_members', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('constellation_id')->constrained('constellations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Position in Constellation
            $table->unsignedTinyInteger('position'); // 1-7 (or 1-3 for triangulum)
            $table->boolean('is_alcyone')->default(false); // Is this member the center/receiver

            // Member Status
            $table->enum('status', ['active', 'waiting', 'completed', 'removed'])->default('active');
            // active: participating in tours
            // waiting: waiting for constellation to fill
            // completed: finished all tours
            // removed: left or removed from constellation

            // Tour Progress for This Member
            $table->unsignedTinyInteger('current_tour')->default(1); // Current tour (1-7)
            $table->unsignedTinyInteger('tours_completed')->default(0); // Number of completed tours

            // Financial Tracking
            $table->decimal('total_contributed', 10, 2)->default(0); // Total amount this member has paid
            $table->decimal('total_received', 10, 2)->default(0); // Total amount this member has received
            $table->decimal('net_earnings', 10, 2)->default(0); // Net earnings (received - contributed)

            // Dates
            $table->timestamp('joined_at'); // When member joined this constellation
            $table->timestamp('activated_at')->nullable(); // When constellation became active
            $table->timestamp('completed_at')->nullable(); // When member completed all tours
            $table->timestamp('removed_at')->nullable(); // When/if member was removed

            // Performance Tracking
            $table->unsignedInteger('days_to_complete')->nullable(); // Days taken to complete all tours
            $table->boolean('on_time_payments')->default(true); // Track payment punctuality

            $table->timestamps();
            $table->softDeletes();

            // Unique constraint - user can only be in one position per constellation
            $table->unique(['constellation_id', 'user_id']);
            $table->unique(['constellation_id', 'position']);

            // Indexes
            $table->index('constellation_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('is_alcyone');
            $table->index(['constellation_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constellation_members');
    }
};
