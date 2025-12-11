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
        // Add 'bidding' to the ENUM list
        // Note: We redefine the entire column to be safe
        Schema::table('projects', function (Blueprint $table) {
            DB::statement("ALTER TABLE projects MODIFY COLUMN status ENUM('available', 'bidding', 'in_progress', 'completed', 'cancelled') DEFAULT 'available'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert back to original ENUM list
            DB::statement("ALTER TABLE projects MODIFY COLUMN status ENUM('available', 'in_progress', 'completed', 'cancelled') DEFAULT 'available'");
        });
    }
};
