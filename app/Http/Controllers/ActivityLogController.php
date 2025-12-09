<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Filter by model type if provided
        if ($request->has('model_type')) {
            $logs = ActivityLog::where('model_type', $request->model_type)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('activity-logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('activity-logs.show', compact('activityLog'));
    }
}
