<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Log an activity
     */
    protected function logActivity(string $action, $model, array $oldValues = [], array $newValues = []): void
    {
        ActivityLog::log($action, $model, auth()->user(), $oldValues, $newValues);
    }
}

