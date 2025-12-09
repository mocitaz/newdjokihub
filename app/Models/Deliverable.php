<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deliverable extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'is_completed',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the project that owns this deliverable
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
