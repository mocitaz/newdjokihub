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
        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('payout_amount', 15, 2)->default(0);
            $table->timestamps();
        });

        // Migrate existing data
        // For existing projects with assigned_to, create a pivot entry with full nett_budget
        $projects = \Illuminate\Support\Facades\DB::table('projects')->whereNotNull('assigned_to')->get();
        
        $pivotData = [];
        $now = now();
        
        foreach ($projects as $project) {
            $pivotData[] = [
                'project_id' => $project->id,
                'user_id' => $project->assigned_to,
                'payout_amount' => $project->nett_budget ?? 0, // Fallback to 0 if null, though untypical
                'created_at' => $project->created_at ?? $now,
                'updated_at' => $project->updated_at ?? $now,
            ];
        }

        // Insert in chunks to avoid memory issues if large data
        foreach (array_chunk($pivotData, 500) as $chunk) {
            \Illuminate\Support\Facades\DB::table('project_user')->insert($chunk);
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
        });

        // Restore data (Best effort: Take the first assigned user found)
        $pivots = \Illuminate\Support\Facades\DB::table('project_user')->get();
        foreach ($pivots as $pivot) {
             \Illuminate\Support\Facades\DB::table('projects')
                ->where('id', $pivot->project_id)
                ->whereNull('assigned_to') // Only update if not already set (reverts 1-to-many partially)
                ->update(['assigned_to' => $pivot->user_id]);
        }

        Schema::dropIfExists('project_user');
    }
};
