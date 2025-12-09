<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Log an activity
     */
    public static function log(string $action, $model, ?User $user = null, array $oldValues = [], array $newValues = []): self
    {
        return self::create([
            'user_id' => $user?->id ?? auth()->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'description' => self::generateDescription($action, $model),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected static function generateDescription(string $action, $model): string
    {
        $modelName = class_basename($model);
        return ucfirst($action) . " {$modelName}: " . ($model->name ?? $model->title ?? $model->id);
    }
}
