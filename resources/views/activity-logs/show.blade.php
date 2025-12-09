@extends('layouts.app')

@section('title', 'Activity Log Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Compact Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Activity Log Details</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $activityLog->created_at->format('d F Y H:i:s') }}</p>
        </div>
        <a href="{{ route('activity-logs.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
            Back
        </a>
    </div>

    <div class="space-y-4">
        <!-- Basic Info -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Activity Information</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Action:</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($activityLog->action) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Model:</span>
                    <span class="font-medium text-gray-900">{{ class_basename($activityLog->model_type) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Model ID:</span>
                    <span class="font-medium text-gray-900">{{ $activityLog->model_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">User:</span>
                    <span class="font-medium text-gray-900">{{ $activityLog->user ? $activityLog->user->name : 'System' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Description:</span>
                    <span class="font-medium text-gray-900">{{ $activityLog->description }}</span>
                </div>
            </div>
        </div>

        <!-- Changes (if available) -->
        @if($activityLog->old_values || $activityLog->new_values)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @if($activityLog->old_values)
            <div class="bg-white rounded-lg shadow-[0_2px_20px_rgba(0,0,0,0.08)] border border-gray-200 p-5">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Old Values</h2>
                <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto max-h-96">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($activityLog->new_values)
            <div class="bg-white rounded-lg shadow-[0_2px_20px_rgba(0,0,0,0.08)] border border-gray-200 p-5">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">New Values</h2>
                <pre class="text-xs bg-gray-50 p-4 rounded-xl overflow-auto max-h-96">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
        @endif

        <!-- Technical Info -->
        <div class="bg-white rounded-lg shadow-[0_2px_20px_rgba(0,0,0,0.08)] border border-gray-200 p-5">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Technical Information</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">IP Address:</span>
                    <span class="font-medium text-gray-900">{{ $activityLog->ip_address ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">User Agent:</span>
                    <span class="font-medium text-gray-900 text-xs">{{ Str::limit($activityLog->user_agent ?? '-', 80) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Created At:</span>
                    <span class="font-medium text-gray-900">{{ $activityLog->created_at->format('d M Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

