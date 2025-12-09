@extends('layouts.app')

@section('title', 'System Audit Log')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ expanded: null }">
    
    <!-- Hero Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <span class="flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <p class="text-xs font-mono text-emerald-600 uppercase tracking-widest">System Monitor Active</p>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Audit Stream</h1>
            <p class="text-gray-500 mt-1 font-mono text-xs">Tracking ecosystem modifications and security events.</p>
        </div>
        
        <!-- Quick Stats (Mocked for visual density) -->
        <div class="hidden md:flex gap-6">
            <div class="text-right">
                <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Events (24h)</p>
                <p class="text-xl font-mono font-bold text-gray-900">{{ rand(40, 150) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Security</p>
                <p class="text-xl font-mono font-bold text-blue-600">Secure</p>
            </div>
        </div>
    </div>

    <!-- Timeline Container -->
    <div class="relative">
        <!-- Vertical Line -->
        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-200"></div>

        <div class="space-y-6">
            @php
                $currentDate = null;
            @endphp

            @forelse($logs as $log)
                @php
                    $logDate = $log->created_at->format('Y-m-d');
                    $isNewDay = $currentDate !== $logDate;
                    $currentDate = $logDate;
                    
                    // Determine styling based on action
                    $colors = match($log->action) {
                        'created' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-500'],
                        'updated' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'bg-blue-500'],
                        'deleted' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'bg-red-500'],
                        'login' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'icon' => 'bg-violet-500'],
                        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'icon' => 'bg-gray-500'],
                    };
                @endphp

                @if($isNewDay)
                    <div class="relative pl-14 py-2">
                        <span class="inline-flex px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-xs font-bold text-gray-600 shadow-sm z-10 relative">
                            {{ $log->created_at->isToday() ? 'Today' : ($log->created_at->isYesterday() ? 'Yesterday' : $log->created_at->format('d M Y')) }}
                        </span>
                    </div>
                @endif

                <!-- Timeline Item -->
                <div class="relative pl-14 group">
                    <!-- Dot -->
                    <div class="absolute left-[21px] top-5 w-2.5 h-2.5 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 group-hover:scale-125 transition-transform duration-300 {{ $colors['icon'] }}"></div>

                    <!-- Card -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 hover:shadow-lg hover:border-gray-300 transition-all duration-300 cursor-pointer"
                         @click="expanded = expanded === {{ $log->id }} ? null : {{ $log->id }}">
                        
                        <div class="flex items-start justify-between gap-4">
                            <!-- Left: User & Action -->
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <div class="flex-shrink-0 mt-1">
                                    @if($log->user)
                                        @if($log->user->profile_photo)
                                            <img src="{{ $log->user->profile_photo_url }}" class="w-8 h-8 rounded-lg object-cover shadow-md" alt="{{ $log->user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center font-bold text-xs shadow-md">
                                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shadow-inner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $log->user ? $log->user->name : 'System Monitor' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase {{ $colors['bg'] }} {{ $colors['text'] }} border {{ $colors['border'] }}">
                                            {{ $log->action }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-snug">
                                        {{ $log->description }}
                                        <span class="text-gray-400 mx-1">&middot;</span>
                                        <span class="text-gray-500 font-medium">{{ class_basename($log->model_type) }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Right: Time -->
                            <div class="flex-shrink-0 text-right">
                                <p class="text-xs font-mono text-gray-400">{{ $log->created_at->format('H:i:s') }}</p>
                                <p class="text-[10px] font-mono text-gray-300 mt-0.5">ID:{{ substr($log->id, 0, 8) }}</p>
                            </div>
                        </div>

                        <!-- Expanded Details (Accordion) -->
                        <div x-show="expanded === {{ $log->id }}" 
                             x-collapse
                             class="mt-4 pt-4 border-t border-gray-100 bg-gray-50/50 -mx-4 -mb-4 px-4 pb-4 rounded-b-xl">
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <p class="font-bold text-gray-500 mb-1 uppercase tracking-wider text-[10px]">Context</p>
                                    <div class="bg-white p-2 rounded border border-gray-200 font-mono text-gray-600 break-all">
                                        <span class="text-blue-500">Model:</span> {{ $log->model_type }}<br>
                                        <span class="text-blue-500">ID:</span> {{ $log->model_id }}
                                    </div>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-500 mb-1 uppercase tracking-wider text-[10px]">Metadata</p>
                                    <div class="bg-white p-2 rounded border border-gray-200 font-mono text-gray-600">
                                        <span class="text-purple-500">IP:</span> {{ ucfirst($log->properties['ip'] ?? '127.0.0.1') }}<br>
                                        <span class="text-purple-500">Agent:</span> Browser
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="pl-14 py-12">
                    <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-8 text-center opacity-75">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="text-sm font-bold text-gray-900">System Quiet</h3>
                        <p class="text-xs text-gray-500 mt-1">No activity events recorded in the stream.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $logs->links() }}
    </div>
</div>
@endsection
