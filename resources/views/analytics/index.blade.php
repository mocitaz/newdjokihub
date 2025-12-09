@extends('layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ range: '30d' }">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider mb-2 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                System Monitoring
            </div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Analytics Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Performance metrics and operational insights.</p>
        </div>
        <div class="flex items-center gap-3">

            <a href="{{ route('analytics.export') }}" class="px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold rounded-xl transition-all shadow-lg hover:shadow-gray-900/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Report
            </a>
        </div>
    </div>

    <!-- Hero Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Revenue -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_2px_10px_rgb(0,0,0,0.03)] hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-green-50 text-xs font-bold text-green-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    24%
                </span>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <!-- Projects -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_2px_10px_rgb(0,0,0,0.03)] hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Total Projects</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProjects) }}</p>
        </div>

        <!-- Active Staff -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_2px_10px_rgb(0,0,0,0.03)] hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Active Staff</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($activeStaff) }}</p>
        </div>

        <!-- Completion -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_2px_10px_rgb(0,0,0,0.03)] hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-teal-50 rounded-lg text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                 <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-gray-100 text-xs font-bold text-gray-600">
                    Avg
                </span>
            </div>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Completion Rate</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProjects > 0 ? number_format(($projectStatusStats['completed'] ?? 0) / $totalProjects * 100, 1) : 0 }}%</p>
        </div>
    </div>

    <!-- Main Grid Row 1 (Revenue & Status) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Revenue Trend (Span 2) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-[400px]">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Revenue Trend
                </h3>
            </div>
            <div class="p-6 flex-1 min-h-0">
                <div class="relative w-full h-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Project Status (Span 1) -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-[400px]">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 rounded-t-2xl">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Project Distribution
                </h3>
            </div>
             <div class="p-6 flex-1 min-h-0 flex items-center justify-center">
                <div class="relative w-full h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid Row 2 (Details) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Top Clients -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 rounded-t-2xl">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Top Clients
                </h3>
            </div>
            <div class="p-6 space-y-5">
                @foreach($topClients as $client)
                <div>
                     <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700 truncate" title="{{ $client->client_name }}">{{ $client->client_name }}</span>
                        <span class="text-xs font-bold text-gray-900 bg-gray-100 px-2 py-0.5 rounded">Rp {{ number_format($client->total_revenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, log($client->total_revenue + 1) * 4) }}%"></div>
                    </div>
                </div>
                @endforeach
                @if($topClients->isEmpty())
                <div class="text-center py-8 text-gray-400 text-sm">No client data available</div>
                @endif
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-full">
             <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 rounded-t-2xl">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Top Performers
                </h3>
            </div>
            <div class="divide-y divide-gray-50 overflow-y-auto max-h-[400px]">
                @foreach($leaderboard as $index => $staff)
                <div class="p-4 flex items-center gap-3 hover:bg-gray-50 transition-all">
                     <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg font-bold text-sm border
                        {{ $index === 0 ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                        {{ $index === 1 ? 'bg-slate-50 text-slate-700 border-slate-200' : '' }}
                        {{ $index === 2 ? 'bg-orange-50 text-orange-800 border-orange-200' : '' }}
                        {{ $index > 2 ? 'bg-white text-gray-400 border-gray-100' : '' }}">
                        @if($index === 0) 
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.699-3.189a1 1 0 011.441999999999999 0l1.243 2.332 2.508.365a1 1 0 01.554 1.705l-1.815 1.768.428 2.496a1 1 0 01-1.451 1.054L10 11.165l-2.261 1.169a1 1 0 01-1.451-1.054l.428-2.496-1.815-1.768a1 1 0 01.554-1.705l2.508-.365 1.243-2.332a1 1 0 011.442 0L8.046 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        @elseif($index === 1) 2
                        @elseif($index === 2) 3
                        @else {{ $index + 1 }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $staff->name }}</p>
                        <p class="text-xs text-gray-500 font-medium">{{ $staff->completed_projects_count }} Projects</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-green-600">Rp {{ number_format($staff->total_nett_budget, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 rounded-t-2xl">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Recent Activity
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="relative pl-8 border-l border-gray-100 space-y-6">
                    @foreach($recentActivities as $activity)
                    <div class="relative">
                        <div class="absolute -left-[39px] top-0 w-6 h-6 rounded-full border-2 flex items-center justify-center bg-white 
                            {{ $activity->status == 'completed' ? 'border-green-500 text-green-500' : 'border-blue-500 text-blue-500' }}">
                            <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 leading-tight mb-0.5">{{ $activity->name }}</p>
                            <p class="text-[10px] text-gray-500 font-medium">
                                {{ $activity->status == 'completed' ? 'Completed by' : 'In Progress by' }} 
                                @if($activity->assignees->count() > 0)
                                    {{ $activity->assignees->first()->name }} {{ $activity->assignees->count() > 1 ? '(+' . ($activity->assignees->count() - 1) . ' others)' : '' }}
                                @else
                                    Unassigned
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                    @if($recentActivities->isEmpty())
                        <div class="text-gray-400 text-xs italic">No recent activity</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const revenueLabels = {!! json_encode($monthlyRevenue->keys()) !!};
    const revenueData = {!! json_encode($monthlyRevenue->values()) !!};
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    
    // Gradient
    const gradient = ctxRevenue.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Nett Revenue',
                data: revenueData,
                borderColor: '#4F46E5',
                backgroundColor: gradient,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1F2937',
                    bodyColor: '#1F2937',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6', drawBorder: false },
                    ticks: { callback: function(value) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(value); }, font: {size: 10, family: "'Inter', sans-serif"} }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: {size: 10, family: "'Inter', sans-serif"}, maxTicksLimit: 7 }
                }
            }
        }
    });

    const statusData = {!! json_encode($projectStatusStats) !!};
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(k => k.replace('_', ' ').toUpperCase()),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: {size: 10, family: "'Inter', sans-serif"} } }
            }
        }
    });
</script>
@endsection
