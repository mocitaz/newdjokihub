@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="deliverablesManager({{ $project->id }})">
    <!-- Modern Compact Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('projects.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm group">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
                    @php
                        $statusConfig = [
                            'available' => ['bg-blue-50', 'text-blue-700', 'border-blue-100'],
                            'in_progress' => ['bg-yellow-50', 'text-yellow-700', 'border-yellow-100'],
                            'completed' => ['bg-green-50', 'text-green-700', 'border-green-100'],
                            'cancelled' => ['bg-red-50', 'text-red-700', 'border-red-100']
                        ];
                        $config = $statusConfig[$project->status] ?? $statusConfig['available'];
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                        {{ str_replace('_', ' ', $project->status) }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 font-medium mt-0.5 flex items-center gap-2">
                    <span class="font-mono text-gray-400">Order ID: {{ $project->order_id }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span>Client: {{ $project->client_name ?? 'Anonymous' }}</span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span>Created {{ $project->created_at->format('d M Y') }}</span>
                </p>
            </div>
        </div>
        
        @if(auth()->user()->isAdmin())
        <div class="flex items-center gap-3">
            <button @click="showDeleteModal = true" class="px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm font-semibold rounded-xl transition-all hover:shadow-sm">
                Delete
            </button>
            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Project
            </a>
        </div>
        @endif
    </div>

    <!-- 3-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Sidebar (Financials, Docs, Actions) - Span 4 -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Financial Card -->
            <div class="bg-gray-900 rounded-2xl p-6 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                </div>
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Project Value</h3>
                <p class="text-3xl font-bold tracking-tight mb-6">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</p>
                
                <div class="space-y-3 pt-6 border-t border-gray-800">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400">Total Budget</span>
                        <span class="font-medium text-gray-200">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400">Admin Fee ({{ $project->admin_fee_percentage }}%)</span>
                        <span class="font-medium text-gray-200">Rp {{ number_format($project->admin_fee, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Official Documents
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('projects.poc', $project) }}" target="_blank" class="group flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-purple-50 hover:text-purple-700 transition-colors border border-gray-100 hover:border-purple-100">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">POC Document</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="{{ route('projects.invoice', $project) }}" target="_blank" class="group flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-700 transition-colors border border-gray-100 hover:border-blue-100">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Invoice</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="{{ route('projects.bast', $project) }}" target="_blank" class="group flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-green-50 hover:text-green-700 transition-colors border border-gray-100 hover:border-green-100">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">BAST</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Repositories -->
            @if($project->github_url || $project->google_drive_url)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    Repositories
                </h3>
                <div class="space-y-2">
                    @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" class="group flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 hover:text-gray-900 transition-colors border border-gray-100 hover:border-gray-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-black transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">GitHub Repo</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    @endif
                    
                    @if($project->google_drive_url)
                    <a href="{{ $project->google_drive_url }}" target="_blank" class="group flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-blue-50 hover:text-blue-900 transition-colors border border-gray-100 hover:border-blue-100">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-600 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01 0 .02.047-.02.112 0 .02-.27.513-.601 1.096-.331.584-.61.996-.622.915a.06.06 0 0 0-.04.013c-.01 0-.308.209-.662.464l-.644.464-.644-.464c-.354-.255-.652-.464-.662-.464a.06.06 0 0 0-.04-.013c-.012.081-.291-.331-.622-.915-.331-.583-.601-1.076-.601-1.096 0-.065.01-.112.02-.112-.011-.027 1.661-.047 3.743-.047zm-1.042.868c.24.428.455.776.478.773.024-.003.58.397 1.236.889l1.192.894-1.884 1.341c-1.036.737-1.895 1.34-1.908 1.34-.013 0-2.314-3.974-5.113-8.83l-.062-.108.686 1.205c.378.663 1.83 3.193 3.23 5.62l2.545 4.412 1.3-2.257c.715-1.241 1.3-2.257 1.3-2.257 0 0-1.879-1.342-4.175-2.983l-4.176-2.982 2.92-2.074c1.606-1.141 2.92-2.062 2.92-2.046 0 .016-.21.401-.466.856zm10.702 18.647h-8.086l-1.3-2.257-1.3-2.257 4.093.006 4.092.006-.056.108c-1.606 3.08-2.618 4.394-2.618 4.394zm-14.956 0l-.062-.108c-1.606-2.787-2.936-5.097-2.956-5.132-.02-.036 1.01-1.815 2.29-3.953l2.327-3.888 2.545 4.412 2.545 4.412-1.353 2.115c-.744 1.163-1.353 2.127-1.353 2.142 0 .015-1.821 0-4.047 0h-3.983z"/></svg>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Google Drive</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Zone -->
            @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $project->assignees->contains(auth()->id())))
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Project Actions</h3>
                <div class="flex flex-col gap-3">
                    @if($project->status !== 'completed' && $project->status !== 'cancelled')
                    <form id="completeProjectForm" method="POST" action="{{ route('projects.complete', $project) }}">
                        @csrf
                        <button type="button" @click="showCompleteModal = true" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all hover:shadow-lg shadow-green-200">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Mark as Completed
                        </button>
                    </form>
                    @endif

                    @if($project->status !== 'cancelled')
                    <form method="POST" action="{{ route('projects.cancel', $project) }}" onsubmit="return confirm('Are you sure you want to cancel this project?');">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 hover:bg-red-50 hover:text-red-700 hover:border-red-200 text-gray-700 text-sm font-bold rounded-xl transition-all">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Cancel Project
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endif

        </div>

        <!-- Right Side (Staff, Specs, Deliverables) - Span 8 -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Assigned Staff -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                 <div class="w-full">
                     @forelse($project->assignees as $assignee)
                     <div class="flex items-center gap-4 mb-4 last:mb-0">
                        <div class="relative">
                            @if($assignee->profile_photo_url)
                            <img src="{{ $assignee->profile_photo_url }}" class="w-12 h-12 rounded-2xl object-cover ring-4 ring-gray-50" alt="{{ $assignee->name }}">
                            @else
                            <div class="w-12 h-12 rounded-2xl bg-gray-900 flex items-center justify-center text-white font-bold text-lg ring-4 ring-gray-50">
                                {{ strtoupper(substr($assignee->name, 0, 1)) }}
                            </div>
                            @endif
                             <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wide mb-0.5">Assigned Developer</p>
                            <h3 class="text-base font-bold text-gray-900">{{ $assignee->name }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-500">{{ $assignee->email }}</p>
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                                    Rp {{ number_format($assignee->pivot->payout_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                     </div>
                     @empty
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 ring-4 ring-gray-50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                         <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-0.5">Status</p>
                            <h3 class="text-lg font-bold text-gray-900">Unassigned</h3>
                            <p class="text-sm text-gray-500">
                                @if($project->status === 'available')
                                    Available in Claim Center
                                @else
                                    No staff assigned
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($project->claimed_at)
                <div class="text-right flex-shrink-0 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-0.5">Claimed Date</p>
                    <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($project->claimed_at)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($project->claimed_at)->format('H:i') }} WIB</p>
                </div>
                @endif
            </div>

            <!-- Project Specs (Swapped: Now Above Deliverables) -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Specifications</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Timeline</dt>
                        <dd class="flex items-center gap-2 text-sm font-medium text-gray-900">
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $project->start_date ? $project->start_date->format('d M Y') : 'TBD' }}</span>
                            <span class="text-gray-400">→</span>
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $project->end_date ? $project->end_date->format('d M Y') : 'TBD' }}</span>
                        </dd>
                    </div>
                     <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Description</dt>
                        <dd class="text-sm text-gray-600 leading-relaxed">
                            {{ $project->description ?? 'No description provided.' }}
                        </dd>
                    </div>
                     @if($project->notes)
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Notes</dt>
                        <dd class="text-sm text-gray-600 leading-relaxed bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                            {{ $project->notes }}
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Deliverables (Swapped: Now Below Specs) -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                         <h3 class="text-base font-bold text-gray-900">Deliverables</h3>
                         <p class="text-xs text-gray-500 mt-0.5">Checklist of requirements</p>
                    </div>
                    @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $project->assignees->contains(auth()->id())))
                    <button @click="showAddModal = true" class="px-4 py-2 bg-white border border-gray-200 shadow-sm hover:shadow hover:border-gray-300 text-gray-700 text-xs font-bold rounded-lg transition-all flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Item
                    </button>
                    @endif
                </div>

                <div class="p-6 space-y-3" id="deliverables-list">
                    @forelse($project->deliverables as $deliverable)
                    <div class="group flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-200 deliverable-item" data-id="{{ $deliverable->id }}">
                        <div class="flex-shrink-0 mt-1">
                             <input type="checkbox" 
                                   @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $project->assignees->contains(auth()->id())))
                                   @change="toggleDeliverable({{ $deliverable->id }})"
                                   @else
                                   disabled
                                   @endif
                                   {{ $deliverable->is_completed ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded-md border-gray-300 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 transition-all {{ $deliverable->is_completed ? 'line-through text-gray-500' : '' }}">
                                {{ $deliverable->name }}
                            </p>
                            @if($deliverable->description)
                            <p class="text-xs text-gray-500 mt-0.5 transition-all {{ $deliverable->is_completed ? 'line-through text-gray-400' : '' }}">
                                {{ $deliverable->description }}
                            </p>
                            @endif
                        </div>
                        
                         @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $project->assignees->contains(auth()->id())))
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editDeliverable({{ $deliverable->id }}, @js($deliverable->name), @js($deliverable->description ?? ''))" 
                                    class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button @click="deleteDeliverable({{ $deliverable->id }})" 
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                         <div class="bg-gray-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No deliverables yet</p>
                        <p class="text-xs text-gray-500 mt-1">Add items to track progress.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    
    <!-- Modal -->
    <div x-show="showAddModal || showEditModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-md bg-black/40"
         @click.away="closeModal()">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-gray-100" @click.stop>
            <h3 class="text-lg font-bold text-gray-900 mb-6" x-text="showEditModal ? 'Edit Deliverable' : 'Add New Deliverable'"></h3>
            <form @submit.prevent="showEditModal ? updateDeliverable() : addDeliverable()">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Deliverable Name *</label>
                        <input type="text" 
                               x-model="formData.name" 
                               required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-medium text-gray-900 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Description</label>
                        <textarea x-model="formData.description" 
                                  rows="3"
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all font-medium text-gray-900 placeholder-gray-400"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3 mt-8">
                    <button type="button" 
                            @click="closeModal()"
                            class="px-5 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 rounded-xl transition-colors text-sm font-bold">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all shadow-lg shadow-blue-200 text-sm font-bold">
                        <span x-text="showEditModal ? 'Save Changes' : 'Add Deliverable'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 border border-gray-100" @click.away="showDeleteModal = false">
            <div class="flex items-center gap-3 text-red-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-lg font-bold">Delete Project</h3>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete project <strong>{{ $project->name }}</strong>? This action cannot be undone. All deliverables and data will be permanently removed.
            </p>

            <form method="POST" action="{{ route('projects.destroy', $project) }}">
                @csrf
                @method('DELETE')
                
                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold shadow-lg shadow-red-500/30">
                        Yes, Delete Project
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Complete Project Confirmation Modal -->
    <div x-show="showCompleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 border border-gray-100" @click.away="showCompleteModal = false">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Complete Project?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Are you sure you want to mark this project as completed? This will update the status and notify the relevant parties.
            </p>

            <div class="flex gap-3">
                <button @click="showCompleteModal = false" class="flex-1 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button @click="document.getElementById('completeProjectForm').submit()" class="flex-1 py-2.5 bg-green-600 text-white font-bold text-xs rounded-xl hover:bg-green-700 transition-colors shadow-lg shadow-green-500/30">
                    Yes, Complete
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deliverablesManager(projectId) {
    return {
        projectId: projectId,
        showDeleteModal: false,
        showCompleteModal: false,
        showAddModal: false,
        showEditModal: false,
        editingId: null,
        formData: {
            name: '',
            description: ''
        },
        
        addDeliverable() {
            fetch(`/projects/${this.projectId}/deliverables`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(this.formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add deliverable');
            });
        },
        
        editDeliverable(id, name, description) {
            this.editingId = id;
            this.formData.name = name;
            this.formData.description = description;
            this.showEditModal = true;
        },
        
        updateDeliverable() {
            fetch(`/projects/${this.projectId}/deliverables/${this.editingId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(this.formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update deliverable');
            });
        },
        
        toggleDeliverable(id) {
            fetch(`/projects/${this.projectId}/deliverables/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to toggle deliverable');
            });
        },
        
        deleteDeliverable(id) {
            if (!confirm('Are you sure you want to delete this deliverable?')) {
                return;
            }
            
            fetch(`/projects/${this.projectId}/deliverables/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete deliverable');
            });
        },
        
        closeModal() {
            this.showAddModal = false;
            this.showEditModal = false;
            this.editingId = null;
            this.formData = { name: '', description: '' };
        }
    }
}
</script>
@endpush
@endsection
