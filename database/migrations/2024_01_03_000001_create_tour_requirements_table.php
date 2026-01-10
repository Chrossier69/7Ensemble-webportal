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
        Schema::create('tour_requirements', function (Blueprint $table) {
            $table->id();

            // Tour Configuration
            $table->unsignedTinyInteger('tour_number'); // 1-7
            $table->enum('constellation_type', ['triangulum', 'pleiades']); // 3 or 7 members

            // Financial Requirements
            $table->decimal('amount_to_pay', 10, 2); // Amount user pays to Alcyone
            $table->decimal('amount_to_receive', 10, 2); // Amount user receives from constellation
            $table->decimal('amount_to_keep', 10, 2); // Net earnings (receive - pay)
            $table->decimal('next_tour_payment', 10, 2)->nullable(); // Payment for next tour

            // Tour Details
            $table->string('tour_name')->nullable(); // Optional name (Tour 1, Tour 2, etc.)
            $table->text('description')->nullable();
            $table->unsignedInteger('expected_duration_days')->default(30); // Expected days to complete

            // Requirements
            $table->boolean('requires_previous_tour_completion')->default(true);
            $table->boolean('requires_payment_verification')->default(true);

            $table->timestamps();

            // Unique constraint - one requirement per tour per type
            $table->unique(['tour_number', 'constellation_type']);

            // Indexes
            $table->index('tour_number');
            $table->index('constellation_type');
        });

        // Seed initial tour requirements
        DB::table('tour_requirements')->insert([
            // Triangulum (3 members) - 7 Tours
            [
                'tour_number' => 1,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 21.00,
                'amount_to_receive' => 42.00,
                'amount_to_keep' => 21.00,
                'next_tour_payment' => 42.00,
                'tour_name' => 'Tour 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 2,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 42.00,
                'amount_to_receive' => 84.00,
                'amount_to_keep' => 63.00,
                'next_tour_payment' => 84.00,
                'tour_name' => 'Tour 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 3,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 84.00,
                'amount_to_receive' => 168.00,
                'amount_to_keep' => 147.00,
                'next_tour_payment' => 168.00,
                'tour_name' => 'Tour 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 4,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 168.00,
                'amount_to_receive' => 336.00,
                'amount_to_keep' => 315.00,
                'next_tour_payment' => 336.00,
                'tour_name' => 'Tour 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 5,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 336.00,
                'amount_to_receive' => 672.00,
                'amount_to_keep' => 651.00,
                'next_tour_payment' => 672.00,
                'tour_name' => 'Tour 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 6,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 672.00,
                'amount_to_receive' => 1344.00,
                'amount_to_keep' => 1323.00,
                'next_tour_payment' => 1344.00,
                'tour_name' => 'Tour 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 7,
                'constellation_type' => 'triangulum',
                'amount_to_pay' => 1344.00,
                'amount_to_receive' => 2688.00,
                'amount_to_keep' => 2667.00,
                'next_tour_payment' => null,
                'tour_name' => 'Tour 7',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pléiades (7 members) - 7 Tours
            [
                'tour_number' => 1,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 21.00,
                'amount_to_receive' => 147.00,
                'amount_to_keep' => 126.00,
                'next_tour_payment' => 147.00,
                'tour_name' => 'Tour 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 2,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 147.00,
                'amount_to_receive' => 1029.00,
                'amount_to_keep' => 1008.00,
                'next_tour_payment' => 1029.00,
                'tour_name' => 'Tour 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 3,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 1029.00,
                'amount_to_receive' => 7203.00,
                'amount_to_keep' => 7182.00,
                'next_tour_payment' => 7203.00,
                'tour_name' => 'Tour 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 4,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 7203.00,
                'amount_to_receive' => 50421.00,
                'amount_to_keep' => 50400.00,
                'next_tour_payment' => 50421.00,
                'tour_name' => 'Tour 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 5,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 50421.00,
                'amount_to_receive' => 352947.00,
                'amount_to_keep' => 352926.00,
                'next_tour_payment' => 352947.00,
                'tour_name' => 'Tour 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 6,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 352947.00,
                'amount_to_receive' => 2470629.00,
                'amount_to_keep' => 2470608.00,
                'next_tour_payment' => 2470629.00,
                'tour_name' => 'Tour 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tour_number' => 7,
                'constellation_type' => 'pleiades',
                'amount_to_pay' => 2470629.00,
                'amount_to_receive' => 17294403.00,
                'amount_to_keep' => 17294382.00,
                'next_tour_payment' => null,
                'tour_name' => 'Tour 7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_requirements');
    }
};
