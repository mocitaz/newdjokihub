@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" 
     x-data="{ viewMode: localStorage.getItem('staffViewMode') || 'card', deleteModalOpen: false, staffToDeleteUrl: '' }" 
     x-init="$watch('viewMode', value => localStorage.setItem('staffViewMode', value))">
    
    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModalOpen" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div x-show="deleteModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     @click.outside="deleteModalOpen = false"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100">
                    
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-12 sm:w-12">
                                <svg class="h-8 w-8 text-red-500 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-xl font-bold leading-6 text-slate-900" id="modal-title">Delete Staff Member</h3>
                                <div class="mt-3">
                                    <p class="text-sm text-slate-500 leading-relaxed">
                                        Are you sure you want to delete this staff member? This action <span class="font-bold text-red-600">cannot be undone</span> and will remove all their data from the system.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-slate-100">
                        <form :action="staffToDeleteUrl" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center items-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-600/30 hover:bg-red-500 hover:shadow-red-500/40 sm:w-auto transition-all transform hover:-translate-y-0.5">
                                Yes, Delete It
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider mb-2 shadow-sm">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Human Capital
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Staff Management
            </h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Manage your team's potential and track success</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- View Toggle -->
            <div class="flex items-center bg-gray-100 p-1 rounded-lg border border-gray-200">
                <button @click="viewMode = 'card'" 
                        :class="viewMode === 'card' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Cards</span>
                </button>
                <button @click="viewMode = 'table'" 
                        :class="viewMode === 'table' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span>List</span>
                </button>
            </div>

            @if(auth()->user()->isAdmin())
            <a href="{{ route('staff.create') }}" class="group relative px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg transition-all hover:shadow-md hover:-translate-y-0.5 overflow-hidden">
                <div class="relative flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Staff</span>
                </div>
            </a>
            @endif
        </div>
    </div>

    <!-- Modern Card View -->
    <div x-show="viewMode === 'card'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
        @forelse($staff as $s)
        <div class="group relative bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
            
            <div class="relative flex flex-col h-full">
                <!-- Top Section: Avatar & Info -->
                <div class="flex items-start gap-4 mb-4">
                    <div class="relative">
                        @if($s->profile_photo_url)
                        <img src="{{ $s->profile_photo_url }}" alt="{{ $s->name }}" class="w-14 h-14 rounded-xl object-cover ring-2 ring-gray-50 shadow-sm">
                        @else
                        <div class="w-14 h-14 rounded-xl bg-gray-900 flex items-center justify-center text-white font-bold text-lg ring-2 ring-gray-50 shadow-sm">
                            {{ strtoupper(substr($s->name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                    </div>
                    
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $s->name }}</h3>
                            <!-- Socials -->
                            <div class="flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @if($s->github)
                                <a href="{{ $s->github }}" target="_blank" class="text-gray-400 hover:text-gray-900 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </a>
                                @endif
                                @if($s->linkedin)
                                <a href="{{ $s->linkedin }}" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 truncate mb-2">{{ $s->email }}</p>
                        
                        @if($s->university)
                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-gray-50 rounded border border-gray-200">
                             @if($s->university->logo_url)
                                @php
                                    $univLogoUrl = str_starts_with($s->university->logo_url, 'logos/') 
                                        ? Storage::url($s->university->logo_url) 
                                        : $s->university->logo_url;
                                @endphp
                                <img src="{{ $univLogoUrl }}" alt="" class="w-3 h-3 object-contain" onerror="this.onerror=null; this.style.display='none';">
                            @endif
                            <span class="text-[10px] font-semibold text-gray-700 uppercase">{{ $s->university->acronym ?? Str::limit($s->university->name, 15) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100 group-hover:border-blue-100 group-hover:bg-blue-50/30 transition-colors">
                        <p class="text-[10px] uppercase font-semibold text-gray-500 mb-0.5">Projects</p>
                        <p class="text-lg font-bold text-gray-900">{{ $s->total_claimed_projects }}</p>
                    </div>
                    <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100 group-hover:border-green-100 group-hover:bg-green-50/30 transition-colors">
                        <p class="text-[10px] uppercase font-semibold text-gray-500 mb-0.5">Earned</p>
                        <p class="text-lg font-bold text-gray-900">
                            <span class="text-xs font-semibold text-gray-500">Rp</span>{{ number_format($s->total_nett_budget, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Success Rate Bar -->
                <div class="mt-auto">
                    <div class="flex justify-between items-end mb-1.5">
                        <span class="text-xs font-semibold text-gray-600">Success Rate</span>
                        <span class="text-xs font-bold text-gray-900">{{ number_format($s->claim_success_rate, 0) }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ min($s->claim_success_rate, 100) }}%"></div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                    <a href="{{ route('staff.show', $s) }}" class="text-xs font-semibold text-gray-900 flex items-center gap-1 group/btn hover:text-blue-600 transition-colors">
                        View Profile
                        <svg class="w-3 h-3 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @if(auth()->user()->isAdmin())
                    <div class="flex items-center gap-3">
                        <a href="{{ route('staff.edit', $s) }}" class="text-gray-400 hover:text-gray-900 transition-colors" title="Edit Staff">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <button type="button" @click="deleteModalOpen = true; staffToDeleteUrl = '{{ route('staff.destroy', $s) }}'" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete Staff">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center">
            <div class="bg-gray-50 rounded-full w-16 h-16 mx-auto flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No staff members found</h3>
            <p class="text-sm text-gray-500 mt-1">Get started by adding a new staff member.</p>
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
                    <tr class="bg-gray-50">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Staff Member</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Institution</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Account</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Claims</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Projects</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Success</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Earnings</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($staff as $s)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-5 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if($s->profile_photo_url)
                                <img src="{{ $s->profile_photo_url }}" class="w-9 h-9 rounded-lg object-cover ring-1 ring-gray-200" alt="">
                                @else
                                <div class="w-9 h-9 rounded-lg bg-gray-900 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($s->name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $s->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $s->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            @if($s->university)
                            <div class="flex items-center gap-2">
                                @if($s->university->logo_url)
                                 @php
                                    $univLogoUrl = str_starts_with($s->university->logo_url, 'logos/') 
                                        ? Storage::url($s->university->logo_url) 
                                        : $s->university->logo_url;
                                @endphp
                                <img src="{{ $univLogoUrl }}" alt="" class="w-4 h-4 object-contain opacity-80" onerror="this.onerror=null; this.style.display='none';">
                                @endif
                                <span class="text-xs font-medium text-gray-700">{{ $s->university->acronym ?? Str::limit($s->university->name, 20) }}</span>
                            </div>
                            @else
                            <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            @if($s->bank && $s->bank_account_number)
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-700">{{ $s->bank->name }}</span>
                                <span class="text-[10px] font-mono text-gray-500">
                                    {{ auth()->user()->isAdmin() ? $s->bank_account_number : '****' . substr($s->bank_account_number, -4) }}
                                </span>
                            </div>
                            @else
                            <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                            {{ $s->total_claims }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $s->total_claimed_projects }}
                            </span>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <div class="h-1.5 w-16 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ min($s->claim_success_rate, 100) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-700 w-8 text-right">{{ number_format($s->claim_success_rate, 0) }}%</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-right">
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($s->total_nett_budget, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap text-right text-xs font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('staff.show', $s) }}" class="text-gray-500 hover:text-blue-600 transition-colors">
                                    View
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('staff.edit', $s) }}" class="text-gray-500 hover:text-gray-900 transition-colors">
                                        Edit
                                    </a>
                                    <button type="button" @click="deleteModalOpen = true; staffToDeleteUrl = '{{ route('staff.destroy', $s) }}'" class="text-gray-500 hover:text-red-600 transition-colors">
                                            Delete
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-500 text-sm">
                            No team members found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50">
            {{ $staff->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
