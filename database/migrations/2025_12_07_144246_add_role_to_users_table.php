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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->default('staff')->after('email');
            $table->string('phone')->nullable()->after('name');
            $table->string('bank_name')->nullable()->after('phone');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
            $table->integer('total_claims')->default(0)->after('role');
            $table->integer('total_claimed_projects')->default(0)->after('total_claims');
            $table->decimal('total_nett_budget', 15, 2)->default(0)->after('total_claimed_projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'total_claims',
                'total_claimed_projects',
                'total_nett_budget'
            ]);
        });
    }
};
