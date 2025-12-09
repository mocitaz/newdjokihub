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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('budget', 15, 2); // Harga Asli
            $table->decimal('admin_fee_percentage', 5, 2)->default(0); // Persentase Admin Fee
            $table->decimal('admin_fee', 15, 2)->default(0); // Admin Fee (calculated)
            $table->decimal('nett_budget', 15, 2); // Nett Budget (diperebutkan staf)
            $table->enum('status', ['available', 'in_progress', 'completed', 'cancelled'])->default('available');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('claimed_at')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
