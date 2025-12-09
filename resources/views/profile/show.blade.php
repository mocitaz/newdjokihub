@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        <!-- Main Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
            
            <!-- Compact Header Background -->
            <div class="h-28 bg-gray-900 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-90"></div>

            <div class="px-6 pb-6 pt-0">
                <div class="flex flex-col md:flex-row items-start gap-6 -mt-10">
                    
                    <!-- Avatar & Quick Info -->
                    <div class="flex-shrink-0 w-full md:w-auto text-center md:text-left">
                        <div class="relative inline-block group">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white p-1 shadow-sm ring-1 ring-gray-100">
                                @if($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" class="w-full h-full rounded-xl object-cover bg-gray-50">
                                @else
                                <div class="w-full h-full rounded-xl bg-gray-100 flex items-center justify-center text-3xl font-bold text-gray-400">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                @endif
                             </div>
                             @if($user->isStaff())
                             <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full shadow-sm" title="Active"></div>
                             @endif
                        </div>

                        <div class="mt-3 md:hidden">
                            <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
                             <div class="flex items-center justify-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $user->isAdmin() ? 'bg-black text-white' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $user->role }}
                                </span>
                                @if($leaderboardPosition)
                                <span class="px-2 py-0.5 rounded bg-yellow-50 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-100">
                                    Rank #{{ $leaderboardPosition }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="hidden md:block mt-3 space-y-2">
                             <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-full px-4 py-1.5 text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Main Info Column -->
                    <div class="flex-1 pt-12 md:pt-14 w-full">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <!-- Name & Roles (Desktop) -->
                            <div class="hidden md:block">
                                <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $user->name }}</h1>
                                <p class="text-sm text-gray-500 font-medium">{{ $user->email }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $user->isAdmin() ? 'bg-black text-white' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                        {{ $user->role }}
                                    </span>
                                    @if($leaderboardPosition)
                                    <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">
                                        Rank #{{ $leaderboardPosition }}
                                    </span>
                                    @endif
                                    @if($user->university)
                                        <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-gray-50 border border-gray-100">
                                            @if($user->university->logo_url)
                                             <img src="{{ asset($user->university->logo_url) }}" class="w-3 h-3 object-contain">
                                            @endif
                                            <span class="text-[10px] font-bold text-gray-600 truncate max-w-[120px]">{{ $user->university->acronym ?? $user->university->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Key Details (Mobile & Desktop Mixed) -->
                            <div class="flex flex-wrap md:justify-end gap-x-6 gap-y-2 text-xs text-gray-500 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $user->phone ?? 'No Phone' }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $user->domisili ?? 'No Location' }}
                                </div>
                            </div>
                        </div>

                         @if($user->isStaff())
                        <!-- Compact Stats Grid -->
                        <div class="grid grid-cols-3 gap-3 mt-6">
                            <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 flex flex-col items-center md:items-start">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Earnings</span>
                                <span class="text-lg font-extrabold text-gray-900 tracking-tight">
                                    <span class="text-xs text-gray-400 font-semibold mr-0.5">Rp</span>{{ number_format($user->total_nett_budget ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 flex flex-col items-center md:items-start">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Completed</span>
                                <span class="text-lg font-extrabold text-gray-900 tracking-tight">{{ $user->total_claimed_projects ?? 0 }}</span>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 flex flex-col items-center md:items-start">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Success Rate</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-lg font-extrabold {{ ($user->claim_success_rate ?? 0) >= 90 ? 'text-green-600' : 'text-gray-900' }} tracking-tight">{{ number_format($user->claim_success_rate ?? 0, 0) }}%</span>
                                </div>
                            </div>
                        </div>
                        @else
                         <div class="mt-6 p-4 bg-gray-50 rounded-xl text-center text-sm text-gray-500">
                            Logged in as Administrator
                        </div>
                        @endif

                    </div>
                    
                     <div class="block md:hidden w-full">
                         <a href="{{ route('profile.edit') }}" class="flex items-center justify-center w-full px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Split Content: Bank Info & Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8 pt-8 border-t border-gray-100">
                    
                    <!-- Left: Bank & Personal Details -->
                    <div class="lg:col-span-1 space-y-6">
                        @if($user->isStaff())
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Payout Details</h3>
                            <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-900 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase">{{ $user->bank_name ?? 'NOT SET' }}</p>
                                        <p class="text-sm font-mono font-bold text-gray-900">{{ $user->bank_account_number ? chunk_split($user->bank_account_number, 4, ' ') : '••••' }}</p>
                                    </div>
                                </div>
                                <div class="text-xs font-medium text-gray-500 border-t border-gray-50 pt-2 flex justify-between">
                                    <span>Account Name</span>
                                    <span class="font-bold text-gray-900">{{ Str::limit($user->bank_account_name ?? '-', 20) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($user->university || $user->program_study)
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Education</h3>
                            <div class="flex items-start gap-3">
                                @if($user->university && $user->university->logo_url)
                                    <img src="{{ asset($user->university->logo_url) }}" class="w-10 h-10 object-contain p-1 border border-gray-200 rounded-lg bg-white">
                                @else
                                    <div class="w-10 h-10 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-gray-900 leading-snug">{{ $user->university->name ?? 'University' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $user->program_study ?? 'Major Not Set' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Socials -->
                        <div>
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Connections</h3>
                            <div class="flex flex-col gap-2">
                                @if($user->github)
                                <a href="{{ $user->github }}" target="_blank" class="flex items-center gap-2 text-xs font-medium text-gray-600 hover:text-black">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    {{ str_replace('https://github.com/', '', $user->github) }}
                                </a>
                                @endif
                                @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" class="flex items-center gap-2 text-xs font-medium text-gray-600 hover:text-blue-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    LinkedIn Profile
                                </a>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Right: Recent Activity -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Recent Project Activity</h3>
                            <a href="{{ route('projects.index') }}" class="text-[10px] font-bold text-gray-500 hover:text-black">View All</a>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl border border-gray-100 overflow-hidden">
                             @forelse($user->assignedProjects->take(5) ?? [] as $project)
                            <div class="group p-3 flex items-center justify-between border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 group-hover:border-gray-300">
                                        {{ strtoupper(substr($project->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-gray-900 truncate max-w-[150px] sm:max-w-xs">{{ $project->name }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $project->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0 px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                    {{ str_replace('_', ' ', $project->status) }}
                                </span>
                            </div>
                            @empty
                            <div class="p-8 text-center text-xs text-gray-400">
                                No recent projects yet.
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
