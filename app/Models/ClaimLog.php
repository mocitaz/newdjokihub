<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimLog extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'success',
        'message',
        'claim_duration_seconds',
        'attempted_at',
    ];

    protected function casts(): array
    {
        return [
            'success' => 'boolean',
            'attempted_at' => 'datetime',
        ];
    }

    /**
     * Get the project for this claim log
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who attempted the claim
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
