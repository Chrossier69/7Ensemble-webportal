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
        Schema::create('constellations', function (Blueprint $table) {
            $table->id();

            // Constellation Type
            $table->enum('type', ['triangulum', 'pleiades'])->default('pleiades'); // 3 or 7 members
            $table->string('name')->nullable(); // Optional constellation name
            $table->string('code')->unique(); // Unique identifier (e.g., CONST-2024-001)

            // Alcyone (Center Person - Receiver)
            $table->foreignId('alcyone_id')->nullable()->constrained('users')->nullOnDelete();

            // Tour Progress
            $table->unsignedTinyInteger('current_tour')->default(1); // 1-7
            $table->unsignedTinyInteger('max_members'); // 3 for triangulum, 7 for pleiades
            $table->unsignedTinyInteger('current_members')->default(0); // Current member count

            // Status
            $table->enum('status', ['forming', 'active', 'completed', 'disbanded', 'frozen'])->default('forming');
            // forming: waiting for members
            // active: all members joined, active tours
            // completed: all 7 tours completed
            // disbanded: constellation dissolved
            // frozen: temporarily suspended

            // Financial Tracking
            $table->decimal('total_collected', 12, 2)->default(0); // Total money collected
            $table->decimal('total_distributed', 12, 2)->default(0); // Total money distributed
            $table->decimal('pending_amount', 10, 2)->default(0); // Amount pending distribution

            // Dates
            $table->timestamp('formed_at')->nullable(); // When constellation became active
            $table->timestamp('completed_at')->nullable(); // When all tours completed
            $table->timestamp('last_tour_at')->nullable(); // Last tour completion date

            // Metadata
            $table->json('metadata')->nullable(); // Additional data (settings, notes, etc.)

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('alcyone_id');
            $table->index('current_tour');
            $table->index(['type', 'status']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constellations');
    }
};
