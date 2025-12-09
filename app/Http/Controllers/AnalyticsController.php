<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ClaimLog;
use App\Exports\ProjectsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Claim Trend Chart Data
        $now = Carbon::now();
        $last30Days = Carbon::now()->subDays(30);
        
        // Projects created in last 30 days
        $projectsCreated = Project::where('created_at', '>=', $last30Days)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Projects claimed within 1 hour
        $projectsClaimed1Hour = Project::where('created_at', '>=', $last30Days)
            ->whereNotNull('claimed_at')
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, claimed_at) <= 1')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Projects not claimed after 24 hours
        $projectsNotClaimed24Hours = Project::where('created_at', '>=', $last30Days)
            ->where(function($query) {
                $query->whereNull('claimed_at')
                    ->orWhereRaw('TIMESTAMPDIFF(HOUR, created_at, claimed_at) > 24');
            })
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Monthly Revenue Trend (Last 30 Days) -> based on completed projects
        $revenueData = Project::where('status', 'completed')
            ->where('updated_at', '>=', $last30Days)
            ->selectRaw('DATE(updated_at) as date, SUM(nett_budget) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Fill missing dates with 0
        $monthlyRevenue = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $monthlyRevenue->put($date, $revenueData->get($date, 0));
        }

        // Project Status Distribution
        $projectStatusStats = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Overall Financials (All Time)
        $totalRevenue = Project::where('status', 'completed')->sum('nett_budget');
        $totalProjects = Project::count();
        $activeStaff = User::where('role', 'staff')->count();

        // Top Clients by Revenue
        $topClients = Project::where('status', 'completed')
            ->whereNotNull('client_name')
            ->where('client_name', '!=', '')
            ->select('client_name', DB::raw('SUM(nett_budget) as total_revenue'), DB::raw('COUNT(*) as project_count'))
            ->groupBy('client_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Recent Activity (Latest Completed Projects)
        $recentActivities = Project::with('assignees')
            ->whereIn('status', ['completed', 'in_progress'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Claim Velocity Breakdown
        $claimedProjects = Project::whereNotNull('claimed_at')
            ->where('created_at', '>=', $last30Days)
            ->get();

        $velocityBreakdown = [
            'under_1_hour' => 0,
            '1_to_6_hours' => 0,
            'over_6_hours' => 0,
        ];

        foreach ($claimedProjects as $project) {
            $hours = $project->created_at->diffInHours($project->claimed_at);
            if ($hours < 1) {
                $velocityBreakdown['under_1_hour']++;
            } elseif ($hours <= 6) {
                $velocityBreakdown['1_to_6_hours']++;
            } else {
                $velocityBreakdown['over_6_hours']++;
            }
        }

        $totalClaimed = array_sum($velocityBreakdown);
        $velocityPercentages = [
            'under_1_hour' => $totalClaimed > 0 ? ($velocityBreakdown['under_1_hour'] / $totalClaimed) * 100 : 0,
            '1_to_6_hours' => $totalClaimed > 0 ? ($velocityBreakdown['1_to_6_hours'] / $totalClaimed) * 100 : 0,
            'over_6_hours' => $totalClaimed > 0 ? ($velocityBreakdown['over_6_hours'] / $totalClaimed) * 100 : 0,
        ];

        // Leaderboard - Staff ranked by Total Nett Budget Completed and Claim Speed
        $leaderboard = User::where('role', 'staff')
            ->withCount(['assignedProjects as completed_projects_count' => function($query) {
                $query->where('status', 'completed');
            }])
            // We can't easily use withSum on pivot with HasManyThrough behavior on BelongsToMany directly for summing pivot column
            // accurately without join. However, since we are syncing User stats column `total_nett_budget`, 
            // we should rely on that column for sorting, but here we are dynamically capping 10.
            // Let's use the `total_nett_budget` column on User table which we trust SyncUserStats to maintain.
            ->withAvg(['claimLogs as avg_claim_speed_seconds' => function($query) {
                $query->where('success', true)->whereNotNull('claim_duration_seconds');
            }], 'claim_duration_seconds')
            ->orderByDesc('total_nett_budget') 
            ->orderByDesc('total_claimed_projects')
            ->orderBy('name', 'asc')
            ->get();
            
        // Calculate hours from seconds
        foreach ($leaderboard as $staff) {
            $staff->avg_claim_speed_hours = $staff->avg_claim_speed_seconds ? round($staff->avg_claim_speed_seconds / 3600, 2) : null;
        }

        return view('analytics.index', compact(
            'projectsCreated',
            'projectsClaimed1Hour',
            'projectsNotClaimed24Hours',
            'velocityBreakdown',
            'velocityPercentages',
            'velocityPercentages',
            'leaderboard',
            'monthlyRevenue',
            'projectStatusStats',
            'totalRevenue',
            'totalProjects',
            'activeStaff',
            'topClients',
            'recentActivities'
        ));
    }

    public function export()
    {
        $projects = Project::with(['assignedUser', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(new ProjectsExport($projects), 'analytics-projects-' . now()->format('Y-m-d') . '.xlsx');
    }
}
