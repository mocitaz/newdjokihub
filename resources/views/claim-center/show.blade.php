@extends('layouts.app')

@section('title', 'Claim: ' . $project->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="claimPage({{ $project->id }})">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('claim-center.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm group">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                 <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700">Available</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-100 text-purple-700">Fast Claim</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
                <p class="text-sm text-gray-500 font-mono mt-0.5">Order ID: {{ $project->order_id }}</p>
            </div>
        </div>
        
        @if(auth()->user()->isStaff())
        <div class="hidden md:block">
            <button @click="openCommitmentModal" 
                    :disabled="isClaiming"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-200 hover:shadow-2xl hover:-translate-y-1 flex items-center gap-2">
                <span x-show="!isClaiming">Claim Project Now</span>
                <span x-show="isClaiming" x-cloak>Processing...</span>
                <svg x-show="!isClaiming" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </button>
        </div>
        @endif
    </div>

    <!-- 3-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Sidebar (Financials & Info) - Span 4 -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Financial Card (Hero) -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 text-white relative overflow-hidden group shadow-2xl shadow-gray-200/50">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-32 h-32 transform rotate-12 -mr-8 -mt-8" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                </div>
                <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">You Will Earn (Nett)</h3>
                <p class="text-4xl font-extrabold tracking-tight mb-8 text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-white">
                    Rp {{ number_format($project->nett_budget, 0, ',', '.') }}
                </p>
                
                <div class="space-y-3 pt-6 border-t border-gray-700/50">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400">Total Budget</span>
                        <span class="font-medium text-gray-200">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Client Info (Anonymous Support) -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                 <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-4">Project Context</h3>
                 <div class="space-y-4">
                     <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Client</p>
                        @if($project->client_name)
                            <p class="text-sm font-bold text-gray-900">{{ $project->client_name }}</p>
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                <p class="text-sm font-bold text-gray-500 italic">Anonymous Client</p>
                            </div>
                        @endif
                     </div>
                     <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Timeline</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $project->start_date ? $project->start_date->format('d M Y') : 'TBD' }} 
                            <span class="text-gray-400 mx-1">→</span> 
                            {{ $project->end_date ? $project->end_date->format('d M Y') : 'TBD' }}
                        </p>
                     </div>
                 </div>
            </div>

            <!-- Mobile Claim Button -->
            @if(auth()->user()->isStaff())
            <div class="block md:hidden">
                <button @click="openCommitmentModal" 
                        :disabled="isClaiming"
                        class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-2">
                    <span x-show="!isClaiming">Claim Project Now</span>
                    <span x-show="isClaiming" x-cloak>Processing...</span>
                </button>
            </div>
            @endif

        </div>

        <!-- Right Side (Specs & Deliverables) - Span 8 -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Description & Notes -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Project Overview</h2>
                <div class="prose prose-sm max-w-none text-gray-600">
                    <p class="leading-relaxed whitespace-pre-line">{{ $project->description ?? 'No specific description provided.' }}</p>
                </div>
                
                @if($project->notes)
                <div class="mt-6 bg-yellow-50 rounded-xl p-5 border border-yellow-100 cursor-help" title="Additional Notes">
                    <h4 class="text-xs font-bold text-yellow-800 uppercase tracking-wide mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Important Notes
                    </h4>
                    <p class="text-sm text-yellow-800 leading-relaxed">{{ $project->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Deliverables -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-900">Required Deliverables</h3>
                    <p class="text-xs text-gray-500 mt-1">These are the items you must complete to finish this project.</p>
                </div>
                
                <div class="p-6 space-y-3">
                    @forelse($project->deliverables as $index => $deliverable)
                    <div class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 bg-white hover:border-blue-100 transition-colors">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold font-mono border border-blue-100">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $deliverable->name }}</p>
                            @if($deliverable->description)
                            <p class="text-xs text-gray-500 mt-1">{{ $deliverable->description }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">No specific deliverables listed</p>
                        <p class="text-xs text-gray-500">Please check with the admin or description for details.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    <!-- Commitment Modal (Alpine.js) -->
    <div x-show="showCommitmentModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 border border-gray-100 relative overflow-hidden" @click.away="showCommitmentModal = false">
            
            <div class="mb-5 text-center">
                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Commitment Agreement</h3>
                <p class="text-xs text-gray-500 mt-1">Confirm your commitment to claim this project.</p>
            </div>

            <div class="space-y-2 mb-6">
                <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-transparent hover:border-gray-100">
                    <input type="checkbox" x-model="commitments.requirements" class="mt-0.5 w-3.5 h-3.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-xs font-medium text-gray-600 leading-snug">I have read and understood the project requirements.</span>
                </label>
                <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-transparent hover:border-gray-100">
                    <input type="checkbox" x-model="commitments.deadline" class="mt-0.5 w-3.5 h-3.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-xs font-medium text-gray-600 leading-snug">I am available to complete this project within the deadline.</span>
                </label>
                <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-transparent hover:border-gray-100">
                    <input type="checkbox" x-model="commitments.updates" class="mt-0.5 w-3.5 h-3.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-xs font-medium text-gray-600 leading-snug">I agree to provide regular progress updates.</span>
                </label>
                <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors border border-transparent hover:border-gray-100">
                    <input type="checkbox" x-model="commitments.penalty" class="mt-0.5 w-3.5 h-3.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-xs font-medium text-gray-600 leading-snug">I accept responsibility and potential penalties for abandonment.</span>
                </label>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
                <button @click="showCommitmentModal = false" class="px-4 py-2 text-xs font-bold text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </button>
                <button 
                    @click="performClaim" 
                    :disabled="!canClaim"
                    :class="!canClaim ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-200'"
                    class="px-5 py-2 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <span>Confirm Claim</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function claimPage(projectId) {
    return {
        isClaiming: false,
        showCommitmentModal: false,
        commitments: {
            requirements: false,
            deadline: false,
            updates: false,
            penalty: false
        },
        get canClaim() {
            return this.commitments.requirements && this.commitments.deadline && this.commitments.updates && this.commitments.penalty;
        },
        
        openCommitmentModal() {
            this.commitments = { requirements: false, deadline: false, updates: false, penalty: false };
            this.showCommitmentModal = true;
        },
        
        performClaim() {
            this.showCommitmentModal = false;
            
            this.isClaiming = true;
            
            fetch(`/projects/${projectId}/claim`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `/projects/${data.project_id}`;
                } else {
                    alert(data.message || 'Failed to claim project');
                    this.isClaiming = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                this.isClaiming = false;
            });
        }
    }
}
</script>
@endsection
