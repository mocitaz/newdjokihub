@extends('layouts.app')

@section('title', $staff->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ financialRevealed: false, showDeleteModal: false }">
    <!-- Modern Compact Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('staff.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm group">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $staff->name }}</h1>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">Staff Member</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mt-0.5 flex items-center gap-2">
                    {{ $staff->email }}
                    @if($staff->github || $staff->linkedin)
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <div class="flex items-center gap-2">
                        @if($staff->github)
                        <a href="{{ $staff->github }}" target="_blank" class="text-gray-400 hover:text-gray-900 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
                        @endif
                        @if($staff->linkedin)
                        <a href="{{ $staff->linkedin }}" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                        @endif
                    </div>
                    @endif
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             @if(auth()->user()->isAdmin())
            <button @click="showDeleteModal = true" class="px-5 py-2.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm font-semibold rounded-xl transition-all hover:shadow-sm">
                Delete
            </button>
            @endif
            <a href="{{ route('staff.edit', $staff) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Sidebar (Profile) - Span 4 -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-gray-50 to-gray-100 z-0"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="relative mb-4">
                         @if($staff->profile_photo_url)
                        <img src="{{ $staff->profile_photo_url }}" alt="{{ $staff->name }}" class="w-28 h-28 rounded-2xl object-cover ring-4 ring-white shadow-md">
                        @else
                        <div class="w-28 h-28 rounded-2xl bg-gray-900 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-white shadow-md">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                        </div>
                        @endif
                         <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-900 text-center">{{ $staff->name }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ $staff->email }}</p>

                    <!-- Profile Stats Row -->
                    <div class="grid grid-cols-3 gap-2 w-full pt-6 border-t border-gray-100">
                        <div class="text-center">
                            <span class="block text-lg font-bold text-gray-900">{{ $staff->total_claims }}</span>
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Claims</span>
                        </div>
                        <div class="text-center border-l border-r border-gray-100">
                            <span class="block text-lg font-bold text-gray-900">{{ $staff->total_claimed_projects }}</span>
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Projects</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-lg font-bold text-gray-900">{{ number_format($staff->claim_success_rate, 0) }}%</span>
                            <span class="text-xs text-gray-500 font-medium uppercase tracking-wide">Success</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Private Data (Collapsible) -->
            @if(auth()->user()->isAdmin())
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <button @click="financialRevealed = !financialRevealed" class="w-full text-left p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <h3 class="text-sm font-bold text-gray-900">Financial Data</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transform transition-transform duration-200" :class="financialRevealed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="financialRevealed" 
                     x-collapse
                     class="border-t border-gray-100 bg-gray-50/50 p-4 space-y-3">
                     
                     @if($staff->bank)
                     <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Bank</span>
                        <div class="flex items-center gap-2">
                             @if($staff->bank->logo_url)
                            <img src="{{ $staff->bank->logo_url }}" class="w-4 h-4 object-contain" alt="">
                            @endif
                            <span class="text-sm font-bold text-gray-900">{{ $staff->bank->name }}</span>
                        </div>
                     </div>
                     @endif

                     @if($staff->bank_account_number)
                     <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Account No.</span>
                        <span class="text-sm font-mono font-bold text-gray-900">{{ $staff->bank_account_number }}</span>
                     </div>
                     @endif

                     @if($staff->bank_account_name)
                     <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Holder</span>
                        <span class="text-sm font-bold text-gray-900">{{ $staff->bank_account_name }}</span>
                     </div>
                     @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Side - Span 8 -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Personal Details Strip (Horizontal) -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if($staff->university)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                            @if($staff->university->logo_url)
                                <img src="{{ $staff->university->logo_url }}" alt="" class="w-5 h-5 object-contain">
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">University</p>
                            <p class="text-xs font-bold text-gray-900 truncate" title="{{ $staff->university->name }}">{{ $staff->university->acronym ?? Str::limit($staff->university->name, 15) }}</p>
                            @if($staff->program_study)
                            <p class="text-[10px] text-gray-500 truncate" title="{{ $staff->program_study }}">{{ $staff->program_study }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Phone</p>
                            <p class="text-xs font-bold text-gray-900 truncate">{{ $staff->phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Age</p>
                            <p class="text-xs font-bold text-gray-900 truncate">{{ $staff->umur ? $staff->umur . ' Years' : '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Location</p>
                            <p class="text-xs font-bold text-gray-900 truncate" title="{{ $staff->domisili }}">{{ Str::limit($staff->domisili, 15) ?? '-' }}</p>
                        </div>
                    </div>
                 </div>
            </div>
            
            <!-- Financial Highlights Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-900 rounded-2xl p-6 text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.15-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.35 0 .81.91 1.52 2.67 1.98 2.37.63 4.18 1.48 4.18 3.58-.02 1.8-1.31 2.92-3.12 3.31z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-300 mb-1">Total Lifetime Earnings</p>
                    <p class="text-3xl font-bold tracking-tight mb-2">Rp {{ number_format($staff->total_nett_budget, 0, ',', '.') }}</p>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-800 rounded-lg text-xs text-gray-300">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span>
                        Verified Income
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Board Position</p>
                            <p class="text-3xl font-black text-gray-900">#{{ $leaderboardPosition }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-yellow-400 h-2 rounded-full w-3/4"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-right">Top {{ $leaderboardPosition <= 3 ? 'Performer' : 'Contributor' }}</p>
                </div>
            </div>

            <!-- Recent Projects List (Auto-Refreshing) -->
            <livewire:staff-project-history :staff="$staff" />

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
                <h3 class="text-lg font-bold">Delete Staff Member</h3>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete <strong>{{ $staff->name }}</strong>? This action cannot be undone. All associated data will be permanently removed.
            </p>

            <form method="POST" action="{{ route('staff.destroy', $staff) }}">
                @csrf
                @method('DELETE')
                
                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold shadow-lg shadow-red-500/30">
                        Yes, Delete Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
