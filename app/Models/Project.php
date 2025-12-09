<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'client_name',
        'description',
        'budget',
        'admin_fee_percentage',
        'admin_fee',
        'nett_budget',
        'status',
        // 'assigned_to', // Removed
        'created_by',
        'claimed_at',
        'start_date',
        'end_date',
        'notes',
        'github_url',
        'google_drive_url',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'admin_fee_percentage' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'nett_budget' => 'decimal:2',
            'claimed_at' => 'datetime',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the users assigned to this project
     */
    public function assignees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('payout_amount')->withTimestamps();
    }

    /**
     * Get the user who created this project
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Recalculate and distribute payout equally among assignees
     */
    public function recalculatePayouts(): void
    {
        // Always fetch fresh assignees to avoid using cached relation after sync
        $assignees = $this->assignees()->get();
        $count = $assignees->count();
        
        if ($count > 0) {
            $payoutPerUser = $this->nett_budget / $count;
            foreach ($assignees as $user) {
                $this->assignees()->updateExistingPivot($user->id, ['payout_amount' => $payoutPerUser]);
            }
        }
    }

    /**
     * Get claim logs for this project
     */
    public function claimLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClaimLog::class);
    }

    /**
     * Get deliverables for this project
     */
    public function deliverables(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Deliverable::class)->orderBy('order');
    }

    /**
     * Check if project is available for claiming
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Calculate nett budget from budget and admin fee percentage
     */
    public static function calculateNettBudget(float $budget, float $adminFeePercentage): float
    {
        $adminFee = ($budget * $adminFeePercentage) / 100;
        return $budget - $adminFee;
    }

    /**
     * Calculate claim velocity in hours and minutes
     */
    public function getClaimVelocityAttribute(): ?string
    {
        if (!$this->claimed_at || !$this->created_at) {
            return null;
        }

        $seconds = $this->claimed_at->diffInSeconds($this->created_at);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        if ($hours > 0) {
            return "{$hours}j {$minutes}m";
        }
        return "{$minutes}m";
    }
}
