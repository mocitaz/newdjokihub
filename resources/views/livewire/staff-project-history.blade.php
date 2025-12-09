<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" wire:poll.5s>
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-base font-bold text-gray-900">Project History</h3>
        <div class="text-xs font-semibold text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
            {{ $this->staff->assignedProjects()->count() }} Projects
        </div>
    </div>
    
    @if($projects->count() > 0)
    <div class="divide-y divide-gray-100">
        @foreach($projects as $project)
        <div class="p-4 hover:bg-gray-50 transition-colors group">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="flex-shrink-0 text-[10px] font-mono font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">{{ $project->order_id }}</span>
                        <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
                        </h4>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-500">
                        <!-- Use claimed_at ?? created_at logic to avoid Date N/A -->
                        <span>{{ ($project->claimed_at ?? $project->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
                
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold text-gray-900 mb-1">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</p>
                    @php
                        $statusConfig = [
                            'available' => ['bg-gray-100', 'text-gray-700', 'border-gray-200'],
                            'in_progress' => ['bg-blue-50', 'text-blue-700', 'border-blue-100'],
                            'completed' => ['bg-green-50', 'text-green-700', 'border-green-100'],
                            'cancelled' => ['bg-red-50', 'text-red-700', 'border-red-100']
                        ];
                        $config = $statusConfig[$project->status] ?? $statusConfig['available'];
                    @endphp
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                        {{ str_replace('_', ' ', $project->status) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($this->staff->assignedProjects()->count() > 10)
    <div class="p-4 bg-gray-50 text-center border-t border-gray-100">
        <button class="text-sm font-bold text-gray-600 hover:text-gray-900">View All History</button>
    </div>
    @endif
    @else
    <div class="p-12 text-center">
        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
            <p class="text-gray-500 font-medium text-sm">No projects assigned yet</p>
    </div>
    @endif
</div>
