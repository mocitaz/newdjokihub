<div x-data="{ 
    showCommitmentModal: false, 
    selectedProjectId: null,
    commitments: {
        requirements: false,
        deadline: false,
        updates: false,
        penalty: false
    },
    resetCommitments() {
        this.commitments = { requirements: false, deadline: false, updates: false, penalty: false };
    },
    get canClaim() {
        return this.commitments.requirements && this.commitments.deadline && this.commitments.updates && this.commitments.penalty;
    }
}" wire:poll.3s>
    @if(count($projects) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($projects as $project)
        <div class="group bg-white rounded-xl border border-gray-100 hover:border-black/5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative flex flex-col h-full overflow-hidden">
            
            <!-- Quick Claim Badge (Hover) -->
            <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none transform translate-y-1 group-hover:translate-y-0">
                <span class="bg-black text-white text-[9px] font-black px-2 py-1 rounded-md shadow uppercase tracking-wider">Fast Claim</span>
            </div>

            <div class="p-5 flex-1 flex flex-col relative z-0">
                <!-- Header -->
                <div class="flex items-start justify-between mb-3">
                    <span class="inline-block px-2 py-1 rounded-md text-[10px] font-mono font-bold bg-gray-50 text-gray-500 border border-gray-100">
                        {{ $project['order_id'] }}
                    </span>
                </div>

                <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-4 group-hover:text-blue-600 transition-colors h-10">
                    {{ $project['name'] }}
                </h3>

                <!-- Divider -->
                <div class="h-px bg-gray-50 w-full mb-4"></div>

                <!-- Financial Hero -->
                <div class="mb-4">
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Nett Earning</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs font-bold text-gray-400">Rp</span>
                        <span class="text-xl font-black text-gray-900 tracking-tight">{{ number_format($project['nett_budget'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-3 mb-4 text-[10px]">
                    <div class="bg-gray-50 rounded-lg p-2 border border-gray-100">
                        <p class="font-bold text-gray-400 uppercase tracking-wide mb-0.5">Deadline</p>
                        <p class="font-bold text-gray-700">
                             {{ $project['end_date'] ? \Carbon\Carbon::parse($project['end_date'])->format('d M Y') : 'TBD' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-2 border border-gray-100">
                        <p class="font-bold text-gray-400 uppercase tracking-wide mb-0.5">Client</p>
                        <p class="font-bold text-gray-700 truncate">
                            {{ $project['client_name'] ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-auto grid grid-cols-2 gap-2">
                     <a href="{{ route('claim-center.show', $project['id']) }}" class="px-3 py-2 flex items-center justify-center text-xs font-bold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all">
                        Details
                    </a>
                    
                    @if(auth()->user()->isStaff())
                    <button 
                        @click="selectedProjectId = {{ $project['id'] }}; resetCommitments(); showCommitmentModal = true"
                        class="px-3 py-2 flex items-center justify-center text-xs font-bold text-white bg-black rounded-lg hover:bg-gray-800 hover:shadow-lg hover:shadow-gray-200 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed">
                        <span>Claim</span>
                    </button>
                    @else
                    <button disabled class="px-3 py-2 flex items-center justify-center text-xs font-bold text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        Staff Only
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">No Projects Available</h3>
        <p class="text-xs text-gray-500 text-center max-w-xs leading-relaxed">
            All projects have been claimed. Check back later!
        </p>
    </div>
    @endif

    <!-- Commitment Modal (Alpine.js) -->
    <div x-show="showCommitmentModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 border border-gray-100 transform transition-all" @click.away="showCommitmentModal = false">
            <div class="mb-5 text-center">
                <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center mx-auto mb-3 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Claim Commitment</h3>
                <p class="text-xs text-gray-500 mt-1">Confirm your readiness to start.</p>
            </div>

            <div class="space-y-2 mb-6">
                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                    <input type="checkbox" x-model="commitments.requirements" class="mt-0.5 w-3.5 h-3.5 text-black rounded border-2 border-gray-300 focus:ring-black transition-colors">
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900">I understand the requirements.</span>
                </label>
                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                    <input type="checkbox" x-model="commitments.deadline" class="mt-0.5 w-3.5 h-3.5 text-black rounded border-2 border-gray-300 focus:ring-black transition-colors">
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900">I can meet the deadline.</span>
                </label>
                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                    <input type="checkbox" x-model="commitments.updates" class="mt-0.5 w-3.5 h-3.5 text-black rounded border-2 border-gray-300 focus:ring-black transition-colors">
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900">I'll provide regular updates.</span>
                </label>
                <label class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                    <input type="checkbox" x-model="commitments.penalty" class="mt-0.5 w-3.5 h-3.5 text-black rounded border-2 border-gray-300 focus:ring-black transition-colors">
                    <span class="text-xs font-bold text-gray-600 group-hover:text-gray-900">I accept penalty risks.</span>
                </label>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button @click="showCommitmentModal = false" class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button 
                    @click="$wire.claimProject(selectedProjectId); showCommitmentModal = false" 
                    :disabled="!canClaim"
                    :class="!canClaim ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400' : 'bg-black hover:bg-gray-800 text-white shadow-lg shadow-black/20'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2">
                    <span>Confirm Claim</span>
                </button>
            </div>
        </div>
    </div>
</div>
