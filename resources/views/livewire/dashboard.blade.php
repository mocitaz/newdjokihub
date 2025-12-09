<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" wire:poll.5s>
    
    <!-- Trend Logic -->
    @php
        $currentRevenue = $user->isStaff() ? ($myStats['this_month_earned'] ?? 0) : ($monthlyStats['this_month_revenue'] ?? 0);
        $lastRevenue = $user->isStaff() ? ($myStats['last_month_earned'] ?? 0) : ($monthlyStats['last_month_revenue'] ?? 0);
        $revenueGrowth = $lastRevenue > 0 ? (($currentRevenue - $lastRevenue) / $lastRevenue) * 100 : 100;
        $growthColor = $revenueGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
        $growthIcon = $revenueGrowth >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6';
    @endphp

    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest mb-1">Command Center</p>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                Good Afternoon, {{ $user->name }}
            </h1>
            <p class="text-gray-500 mt-1">Here's what's happening in your ecosystem today.</p>
        </div>
        <div>
            <a href="{{ $user->isStaff() ? route('claim-center.index') : route('projects.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
                <svg class="w-4 h-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ $user->isStaff() ? 'Claim New Project' : 'New Project' }}
            </a>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        
        <!-- Metric 1: Financial -->
        <div class="bg-emerald-50/60 backdrop-blur-xl p-5 rounded-2xl border border-emerald-100/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:scale-[1.02] transition-all group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-bold {{ $growthColor }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $growthIcon }}"></path></svg>
                    {{ number_format(abs($revenueGrowth), 1) }}%
                </div>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                {{ $user->isStaff() ? 'Total Earnings' : 'Admin Fee Pool' }}
            </p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">
                @if($user->isStaff())
                    Rp {{ number_format($myStats['total_earned'] ?? 0, 0, ',', '.') }}
                @else
                    Rp {{ number_format($adminFeePool ?? 0, 0, ',', '.') }}
                @endif
            </h3>
        </div>

        <!-- Metric 2: Active Work -->
        <div class="bg-blue-50/60 backdrop-blur-xl p-5 rounded-2xl border border-blue-100/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:scale-[1.02] transition-all group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                {{ $user->isStaff() ? 'My Active Tasks' : 'Projects In Progress' }}
            </p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">
                {{ $user->isStaff() ? ($myStats['in_progress'] ?? 0) : $inProgressProjects }}
            </h3>
        </div>

        <!-- Metric 3: Velocity -->
        <div class="bg-purple-50/60 backdrop-blur-xl p-5 rounded-2xl border border-purple-100/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:scale-[1.02] transition-all group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Avg. Claim Time</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $claimVelocity }}</h3>
            <p class="text-[10px] text-gray-400 font-medium mt-1">From post to claimed</p>
        </div>

        <!-- Metric 4: Completion -->
        <div class="bg-orange-50/60 backdrop-blur-xl p-5 rounded-2xl border border-orange-100/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:scale-[1.02] transition-all group">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-xs font-bold text-gray-400">
                    {{ number_format($completionRate, 0) }}% Success
                </div>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                {{ $user->isStaff() ? 'My Completed' : 'Total Completed' }}
            </p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">
                {{ $user->isStaff() ? ($myStats['completed'] ?? 0) : $completedProjects }}
            </h3>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Daily Briefing & Activity (3 Cols) -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Daily Briefing Widget -->
            <div class="bg-gradient-to-b from-gray-900 to-gray-800 rounded-2xl p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-3 opacity-10 font-bold text-6xl leading-none select-none">
                    {{ date('d') }}
                </div>
                <div class="relative z-10">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Daily Focus</h3>
                    <p class="font-medium text-sm leading-relaxed text-gray-100">
                        @if($user->isStaff())
                            Clear your pending tasks to boost your <span class="text-blue-400 font-bold">Velocity Score</span>. New high-value claims drop at 2PM.
                        @else
                            Review the latest 5 high-budget project requests. System load is currently <span class="text-green-400 font-bold">Optimal</span>.
                        @endif
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-700 flex items-center justify-between text-xs text-gray-400">
                        <span>{{ date('l, F j') }}</span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mini Recent Activity -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 mb-4 px-1">Market Pulse</h3>
                <div class="space-y-4 relative">
                    <div class="absolute top-2 bottom-2 left-2.5 w-0.5 bg-gray-200"></div>
                    
                    @forelse($user->isStaff() ? ($myProjects->take(3) ?? []) : ($recentProjects->take(3) ?? []) as $project)
                    <div class="relative pl-8 group">
                        <div class="absolute left-0 top-1.5 w-5 h-5 rounded-full border-2 border-white bg-white shadow-sm z-10 flex items-center justify-center">
                            <div class="w-2 h-2 rounded-full bg-blue-500 group-hover:scale-125 transition-transform"></div>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 hover:shadow-md transition-all">
                            <p class="text-xs font-bold text-gray-900 truncate">{{ $project->name }}</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">
                                {{ $project->created_at->diffForHumans() }}
                            </p>
                            <span class="inline-block mt-2 px-1.5 py-0.5 bg-gray-50 text-gray-600 text-[10px] font-bold rounded">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-sm text-gray-400 pl-8">No recent activity.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Center: Focus Area (6 Cols) -->
        <div class="lg:col-span-6">
            @if($user->isStaff())
                <!-- STAFF VIEW: Hot Claims -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                        Hot Claims
                        <span class="px-2 py-0.5 bg-red-100 text-red-600 text-[10px] font-black rounded-full uppercase tracking-wide animate-pulse">Live</span>
                    </h3>
                    <a href="{{ route('claim-center.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">View All &rarr;</a>
                </div>

                <div class="space-y-4">
                    @forelse($hotClaims ?? [] as $project)
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/5 to-transparent rounded-bl-full -mr-6 -mt-6 transition-transform group-hover:scale-150"></div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 relative z-10">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">{{ $project->name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-1 max-w-sm">{{ $project->description }}</p>
                                    
                                    <div class="flex items-center gap-4 mt-4">
                                        <div class="flex items-center gap-1.5 text-xs font-medium text-gray-500 bg-gray-50 px-2 py-1 rounded-md">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $project->created_at->diffForHumans(null, true, true) }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs font-medium text-gray-500 bg-gray-50 px-2 py-1 rounded-md">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            {{ $project->difficulty ?? 'Standard' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-auto text-left sm:text-right">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Nett Budget</div>
                                    <div class="text-xl font-bold text-gray-900">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</div>
                                    <a href="{{ route('claim-center.show', $project) }}" class="mt-3 inline-flex items-center justify-center w-full px-4 py-2 bg-black text-white text-xs font-bold rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl">
                                        Claim Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-2xl border border-dashed border-gray-200 text-center">
                            <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-gray-900 font-bold">No Hot Claims</h3>
                            <p class="text-gray-500 text-xs mt-1">Check back later for new opportunities.</p>
                        </div>
                    @endforelse
                </div>

            @else
                <!-- ADMIN VIEW: Operations Feed -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Live Operations</h3>
                    <a href="{{ route('projects.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">Manage All &rarr;</a>
                </div>

                <!-- Mobile Card View (Visible on Mobile) -->
                <div class="md:hidden space-y-4">
                    @forelse($recentProjects ?? [] as $project)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $project->name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    @if($project->assignees->isNotEmpty())
                                        Assigned to <span class="font-medium text-gray-700">{{ $project->assignees->first()->name }}</span>
                                    @else
                                        <span class="text-gray-400 italic">Unassigned</span>
                                    @endif
                                </p>
                            </div>
                            <x-status-badge :status="$project->status" size="xs" />
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                            <span class="font-mono text-sm font-bold text-gray-700">Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 text-xs font-bold hover:underline">
                                Details &rarr;
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 text-sm">No active projects data.</div>
                    @endforelse
                </div>

                <!-- Desktop Table View (Hidden on Mobile) -->
                <div class="hidden md:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="px-5 py-3 font-bold">Project</th>
                                    <th class="px-5 py-3 font-bold">Status</th>
                                    <th class="px-5 py-3 font-bold">Value</th>
                                    <th class="px-5 py-3 font-bold"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentProjects ?? [] as $project)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-5 py-3">
                                        <div class="font-bold text-gray-900">{{ $project->name }}</div>
                                        <div class="text-[10px] text-gray-400">
                                            @if($project->assignees->isNotEmpty())
                                                Assigned to <span class="text-gray-600">{{ $project->assignees->first()->name }}</span>
                                            @else
                                                Unassigned
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$project->status" size="xs" />
                                    </td>
                                    <td class="px-5 py-3 font-mono text-gray-600">
                                        Rp {{ number_format($project->budget, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('projects.show', $project) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-gray-500 text-xs">No active projects data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Insights (3 Cols) -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Status Distribution -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-4">Distribution</h3>
                <div class="space-y-3">
                    @foreach($statusDistribution as $status => $count)
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-600 font-medium capitalize">{{ str_replace('_', ' ', $status) }}</span>
                            <span class="font-bold text-gray-900">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            @php
                                $color = match($status) {
                                    'completed' => 'bg-green-500',
                                    'in_progress' => 'bg-blue-500',
                                    'available' => 'bg-yellow-400',
                                    'canceled' => 'bg-red-400',
                                    default => 'bg-gray-400'
                                };
                                $percent = $totalProjects > 0 ? ($count / $totalProjects) * 100 : 0;
                            @endphp
                            <div class="{{ $color }} h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Performers (Admin Only) -->
            @if($user->isAdmin() && isset($topPerformers))
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-4">Top Performers</h3>
                <div class="space-y-4">
                    @foreach($topPerformers as $index => $performer)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-900 truncate">{{ $performer->name }}</p>
                            <p class="text-[10px] text-gray-500">Rp {{ number_format($performer->total_nett_budget ?? 0, 0, ',', '.') }}</p>
                        </div>
                        @if($index == 0)
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Tip / Rating (Staff) -->
            @if($user->isStaff())
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-5 rounded-2xl text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-wider opacity-80">Pro Tip</span>
                    </div>
                    <p class="text-sm font-medium leading-relaxed opacity-95">
                        Projects with "Complex" tags yield <span class="font-bold text-white">2x Experience</span> points. Target them for fast upgrades.
                    </p>
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
