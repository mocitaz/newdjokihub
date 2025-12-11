@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="projectForm()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Project</h1>
            <p class="text-sm text-gray-500 mt-1">Initialize a new project, set budget, and define deliverables.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50 transition-all">
                Cancel
            </a>
            <button type="button" @click="validateAndSubmit" class="px-5 py-2.5 bg-gray-900 text-white font-bold text-sm rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Create Project
            </button>
        </div>
    </div>

    <form id="createProjectForm" method="POST" action="{{ route('projects.store') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        
        <!-- Left Column (Main Info & Deliverables) - Span 8 -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                 <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Project Details
                </h2>
                
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="col-span-full">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Project Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Redesign Corporate Website" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-semibold text-gray-900 placeholder-gray-400">
                             @error('name')<p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>@enderror
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Client Name</label>
                            <input type="text" name="client_name" value="{{ old('client_name') }}" placeholder="Leave blank for Anonymous"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Order ID (Auto-generated if empty)</label>
                            <input type="text" name="order_id" value="{{ old('order_id') }}" placeholder="e.g. DC-0335"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-mono text-sm font-medium text-gray-900 placeholder-gray-400">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Description</label>
                        <textarea name="description" rows="3" placeholder="Briefly describe the project goals and requirements..."
                                  class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 placeholder-gray-400 leading-relaxed">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Repositories -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                 <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    Repositories
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">GitHub URL</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </span>
                            <input type="url" name="github_url" value="{{ old('github_url') }}" placeholder="https://github.com/username/repo"
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 placeholder-gray-400 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Google Drive URL</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 1.485c2.082 0 3.754.02 3.743.047.01 0 .02.047-.02.112 0 .02-.27.513-.601 1.096-.331.584-.61.996-.622.915a.06.06 0 0 0-.04.013c-.01 0-.308.209-.662.464l-.644.464-.644-.464c-.354-.255-.652-.464-.662-.464a.06.06 0 0 0-.04-.013c-.012.081-.291-.331-.622-.915-.331-.583-.601-1.076-.601-1.096 0-.065.01-.112.02-.112-.011-.027 1.661-.047 3.743-.047zm-1.042.868c.24.428.455.776.478.773.024-.003.58.397 1.236.889l1.192.894-1.884 1.341c-1.036.737-1.895 1.34-1.908 1.34-.013 0-2.314-3.974-5.113-8.83l-.062-.108.686 1.205c.378.663 1.83 3.193 3.23 5.62l2.545 4.412 1.3-2.257c.715-1.241 1.3-2.257 1.3-2.257 0 0-1.879-1.342-4.175-2.983l-4.176-2.982 2.92-2.074c1.606-1.141 2.92-2.062 2.92-2.046 0 .016-.21.401-.466.856zm10.702 18.647h-8.086l-1.3-2.257-1.3-2.257 4.093.006 4.092.006-.056.108c-1.606 3.08-2.618 4.394-2.618 4.394zm-14.956 0l-.062-.108c-1.606-2.787-2.936-5.097-2.956-5.132-.02-.036 1.01-1.815 2.29-3.953l2.327-3.888 2.545 4.412 2.545 4.412-1.353 2.115c-.744 1.163-1.353 2.127-1.353 2.142 0 .015-1.821 0-4.047 0h-3.983z"/></svg>
                            </span>
                            <input type="url" name="google_drive_url" value="{{ old('google_drive_url') }}" placeholder="https://drive.google.com/drive/folders/..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 placeholder-gray-400 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deliverables Builder -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                             <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Deliverables <span class="text-red-500">*</span>
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">Define the checklist items for this project.</p>
                    </div>
                    <button type="button" @click="addDeliverable" class="px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:border-blue-300 hover:text-blue-600 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Item
                    </button>
                </div>
                
                <div class="p-6 space-y-3">
                    <template x-for="(item, index) in deliverables" :key="index">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-3 p-3 md:p-0 bg-gray-50 md:bg-transparent border border-gray-100 md:border-0 rounded-xl md:rounded-none group transition-all hover:bg-gray-50 mb-3 md:mb-0">
                            <div class="hidden md:block flex-shrink-0 mt-3 text-gray-300 font-mono text-xs select-none" x-text="(index + 1) + '.'"></div>
                            
                            <div class="w-full md:flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="relative">
                                     <span class="md:hidden absolute top-2.5 left-3 text-xs font-mono text-gray-400" x-text="(index + 1) + '.'"></span>
                                    <input type="text" :name="'deliverables['+index+'][name]'" x-model="item.name" placeholder="Item Name *" required
                                           class="w-full pl-8 md:pl-3 px-3 py-2 bg-white md:bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm font-semibold text-gray-900 placeholder-gray-400 shadow-sm md:shadow-none">
                                </div>
                                <div>
                                    <input type="text" :name="'deliverables['+index+'][description]'" x-model="item.description" placeholder="Description (Optional)"
                                           class="w-full px-3 py-2 bg-white md:bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm font-medium text-gray-900 placeholder-gray-400 shadow-sm md:shadow-none">
                                </div>
                            </div>
                            
                            <button type="button" @click="removeDeliverable(index)" class="self-end md:self-start md:mt-2 text-gray-400 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-red-50 bg-white md:bg-transparent border md:border-0 border-gray-200 shadow-sm md:shadow-none" title="Remove Item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                    
                    <div x-show="deliverables.length === 0" class="text-center py-6 border-2 border-dashed border-gray-100 rounded-xl">
                        <p class="text-sm text-gray-500 font-medium">No deliverables added yet.</p>
                        <button type="button" @click="addDeliverable" class="mt-2 text-blue-600 hover:text-blue-700 text-xs font-bold hover:underline">Start adding items</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column (Financials & Settings) - Span 4 -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Financial Card -->
            <div class="bg-gray-900 rounded-2xl p-6 text-white shadow-xl shadow-gray-200/50">
                 <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Financials
                </h2>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">Total Budget <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="budget" x-model="budget" @input="calculateNett" step="1000" min="0" required
                                   class="w-full pl-10 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-bold text-white placeholder-gray-600">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5">Admin Fee (%) <span class="text-red-500">*</span></label>
                        <input type="number" name="admin_fee_percentage" x-model="adminFee" @input="calculateNett" step="0.1" min="0" max="100" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-bold text-white placeholder-gray-600">
                    </div>
                    
                    <div class="pt-6 border-t border-gray-700 mt-2">
                        <p class="text-xs text-gray-400 font-medium mb-1">Nett Budget</p>
                        <p class="text-3xl font-bold tracking-tight text-white/90" x-text="formatCurrency(nettBudget)">Rp 0</p>
                    </div>
                </div>
            </div>

            <!-- Assignment & Dates -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                 <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Timeline & Staff
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Assign User (Optional)</label>
                            
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="isAvailable" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-all">
                                <span class="text-xs font-medium text-gray-600">Available in Claim Center</span>
                            </label>
                        </div>
                        
                        <div class="relative">
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar" :class="isAvailable ? 'opacity-50 pointer-events-none' : ''">
                                @foreach($staff as $s)
                                <label class="flex items-center gap-3 p-3 rounded-xl border transition-all cursor-pointer group"
                                       :class="selectedStaff.includes('{{ $s->id }}') ? 'bg-blue-50 border-blue-200 shadow-sm' : 'bg-white border-gray-100 hover:border-blue-200 hover:bg-gray-50'">
                                    
                                    <input type="checkbox" name="assigned_to[]" value="{{ $s->id }}" x-model="selectedStaff" :disabled="isAvailable"
                                           class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 transition-all">
                                    
                                    <div class="flex items-center gap-3">
                                         @if($s->profile_photo_url)
                                            <img src="{{ $s->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-white" title="{{ $s->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white">
                                                {{ strtoupper(substr($s->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $s->name }}</p>
                                            <p class="text-[10px] text-gray-500">{{ $s->email }}</p>
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            
                            <!-- Hidden input to ensure logic works when select is disabled (ensure empty array is sent implicitly if none checked) -->
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-medium text-gray-900 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-yellow-50 rounded-2xl border border-yellow-100 shadow-sm p-6">
                 <h2 class="text-sm font-bold text-yellow-800 uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Additional Notes
                </h2>
                <textarea name="notes" rows="4" placeholder="Any special instructions..."
                          class="w-full px-4 py-3 bg-white border border-yellow-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition-all font-medium text-gray-900 placeholder-gray-400 text-sm">{{ old('notes') }}</textarea>
            </div>

        </div>
    </form>
    <!-- Validation Modal -->
    <div x-show="showErrorModal" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showErrorModal = false"></div>

        <div class="bg-white rounded-2xl p-6 max-w-sm w-full relative z-10 shadow-2xl transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Missing Information</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Please fill in all required fields marked with <span class="text-red-500 font-bold">*</span> before creating the project.
            </p>

            <button @click="showErrorModal = false" class="w-full py-2.5 bg-gray-900 text-white font-bold text-xs rounded-xl hover:bg-gray-800 transition-colors">
                Okay, I'll fix it
            </button>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirmModal" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showConfirmModal = false"></div>

        <div class="bg-white rounded-2xl p-6 max-w-sm w-full relative z-10 shadow-2xl transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Create Project?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Are you sure you want to create this project with the entered details?
            </p>

            <div class="flex gap-3">
                <button @click="showConfirmModal = false" class="flex-1 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button @click="submitForm" class="flex-1 py-2.5 bg-blue-600 text-white font-bold text-xs rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    Yes, Create
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function projectForm() {
    return {
        budget: {{ old('budget', 0) }},
        adminFee: {{ old('admin_fee_percentage', 0) }},
        nettBudget: 0,
        deliverables: @json(old('deliverables', [])),
        showErrorModal: false,
        showConfirmModal: false,
        isAvailable: {{ old('assigned_to') ? 'false' : 'true' }},
        selectedStaff: @json(old('assigned_to', [])),
        
        init() {
            this.calculateNett();
            if (this.deliverables.length === 0) {
                this.addDeliverable(); // Start with one empty item
            }
            
            // Watch isAvailable to clear selection when enabled
            this.$watch('isAvailable', value => {
                if (value) {
                    this.selectedStaff = [];
                }
            });
        },
        
        calculateNett() {
            const b = parseFloat(this.budget) || 0;
            const f = parseFloat(this.adminFee) || 0;
            this.nettBudget = b - (b * f / 100);
        },
        
        formatCurrency(val) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
        },
        
        addDeliverable() {
            this.deliverables.push({ name: '', description: '' });
        },
        
        removeDeliverable(index) {
            this.deliverables.splice(index, 1);
        },

        validateAndSubmit() {
            const form = document.getElementById('createProjectForm');
            if (form.checkValidity()) {
                this.showConfirmModal = true;
            } else {
                this.showErrorModal = true;
                // Optional: Trigger browser's native validation UI to highlight fields
                form.reportValidity();
            }
        },

        submitForm() {
            document.getElementById('createProjectForm').submit();
        }
    }
}
</script>
@endsection
