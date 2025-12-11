<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ viewMode: localStorage.getItem('projectsViewMode') || 'card' }" 
     x-init="$watch('viewMode', value => localStorage.setItem('projectsViewMode', value))"
     wire:poll.5s>
    
    <!-- Modern Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Project Management</p>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Active Projects</h1>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            
            <!-- Search & Filter -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:flex gap-2 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search projects..." 
                           class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400 shadow-sm">
                </div>
                
                <div class="relative w-full sm:w-auto">
                    <select wire:model.live="status" class="w-full sm:w-auto pl-3 pr-10 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all shadow-sm text-gray-700 cursor-pointer appearance-none">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

             <!-- View Toggle & Actions -->
            <div class="flex items-center gap-2">
                <div class="flex items-center bg-gray-100 p-1 rounded-lg border border-gray-200">
                    <button type="button"
                            @click="viewMode = 'card'" 
                            :class="viewMode === 'card' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button type="button"
                            @click="viewMode = 'table'" 
                            :class="viewMode === 'table' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                            class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
                
                <a href="{{ route('projects.export') }}" class="hidden md:flex px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('projects.create') }}" class="flex-1 md:flex-none px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg shadow-gray-900/20 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Project
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Modern Card View -->
    <div x-show="viewMode === 'card'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($projects as $project)
        <div class="group relative bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 flex flex-col h-full">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2">
                     <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-mono font-bold bg-gray-100 text-gray-600">
                        {{ $project->order_id }}
                    </span>
                    @php
                        $statusConfig = [
                            'available' => ['bg-blue-50', 'text-blue-700', 'border-blue-100'],
                            'in_progress' => ['bg-yellow-50', 'text-yellow-700', 'border-yellow-100'],
                            'completed' => ['bg-green-50', 'text-green-700', 'border-green-100'],
                            'cancelled' => ['bg-red-50', 'text-red-700', 'border-red-100']
                        ];
                        $config = $statusConfig[$project->status] ?? $statusConfig['available'];
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                        {{ str_replace('_', ' ', $project->status) }}
                    </span>
                </div>
                <!-- Menu / Actions could go here -->
            </div>
            
            <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                <a href="{{ route('projects.show', $project) }}" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    {{ $project->name }}
                </a>
            </h3>

             <div class="mt-auto pt-4 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 font-medium text-xs uppercase tracking-wide">Budget</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 font-medium text-xs uppercase tracking-wide">Nett</span>
                    <span class="font-bold text-green-600">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</span>
                </div>
                
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center -space-x-2">
                            @if($project->assignees->count() > 0)
                                @foreach($project->assignees->take(3) as $assignee)
                                    @if($assignee->profile_photo_url)
                                        <img src="{{ $assignee->profile_photo_url }}" class="w-6 h-6 rounded-full object-cover ring-2 ring-white" title="{{ $assignee->name }}">
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-gray-900 flex items-center justify-center text-white text-[8px] font-bold ring-2 ring-white" title="{{ $assignee->name }}">
                                            {{ strtoupper(substr($assignee->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-400 pl-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> Unassigned
                                </span>
                            @endif
                            @if($project->assignees->count() > 3)
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-[9px] font-bold ring-2 ring-white">
                                    +{{ $project->assignees->count() - 3 }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">{{ $project->start_date ? $project->start_date->format('d M') : 'No Date' }}</span>
                </div>
            </div>
        </div>
        @empty
         <div class="col-span-full py-12 text-center">
            <div class="bg-gray-50 rounded-full w-16 h-16 mx-auto flex items-center justify-center mb-3">
                 <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No projects found</h3>
            <p class="text-sm text-gray-500 mt-1">Create a new project to get started.</p>
        </div>
        @endforelse
    </div>

    <!-- Modern Table View -->
    <div x-show="viewMode === 'table'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-16">ID</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Project</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Budget</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Nett</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Status</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-64">Assigned</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-4 py-4 whitespace-nowrap text-xs font-mono font-medium text-gray-500 text-center">
                            {{ $project->order_id }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <a href="{{ route('projects.show', $project) }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 transition-colors" title="{{ $project->name }}">
                                    {{ Str::limit($project->name, 45) }}
                                </a>
                                <span class="text-[10px] text-gray-400 mt-0.5">{{ $project->client_name ?? 'Internal Project' }}</span>
                            </div>
                        </td>
                         <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-600">
                            Rp {{ number_format($project->budget, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                            Rp {{ number_format($project->nett_budget, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            @php
                                $statusConfig = [
                                    'available' => ['bg-blue-50', 'text-blue-700', 'border-blue-100'],
                                    'in_progress' => ['bg-yellow-50', 'text-yellow-700', 'border-yellow-100'],
                                    'completed' => ['bg-green-50', 'text-green-700', 'border-green-100'],
                                    'cancelled' => ['bg-red-50', 'text-red-700', 'border-red-100']
                                ];
                                $config = $statusConfig[$project->status] ?? $statusConfig['available'];
                            @endphp
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border w-24 {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                                {{ str_replace('_', ' ', $project->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($project->assignees->count() > 0)
                            <div class="flex items-center gap-3">
                                <div class="flex items-center -space-x-2 shrink-0">
                                    @foreach($project->assignees->take(3) as $assignee)
                                        @if($assignee->profile_photo_url)
                                            <img src="{{ $assignee->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm" title="{{ $assignee->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-[10px] font-bold ring-2 ring-white shadow-sm" title="{{ $assignee->name }}">
                                                {{ strtoupper(substr($assignee->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($project->assignees->count() > 3)
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 text-xs font-bold ring-2 ring-white shadow-sm">
                                            +{{ $project->assignees->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0">
                                    @if($project->assignees->count() == 1)
                                        <span class="text-xs font-bold text-gray-700 truncate w-48 block" title="{{ $project->assignees->first()->name }}">
                                            {{ $project->assignees->first()->name }}
                                        </span>
                                        <span class="text-[10px] text-gray-400">Staff</span>
                                    @else
                                        <span class="text-xs font-bold text-gray-700">{{ $project->assignees->count() }} Staff</span>
                                        <span class="text-[10px] text-gray-400">Assigned</span>
                                    @endif
                                </div>
                            </div>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-50 text-gray-400 text-[10px] font-medium border border-gray-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                    Unassigned
                                </span>
                            @endif
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('projects.show', $project) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('projects.edit', $project) }}" class="p-1.5 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-all" title="Edit Project">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-sm">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <span class="font-medium text-gray-900">No projects found</span>
                                <span class="text-xs text-gray-400 mt-1">Try adjusting your filters or create a new project.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         @if($projects->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>
