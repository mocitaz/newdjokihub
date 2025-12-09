<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Project Health
        $totalProjects = Project::count();
        $inProgressProjects = Project::where('status', 'in_progress')->count();
        $projectHealth = $totalProjects > 0 ? ($inProgressProjects / $totalProjects) * 100 : 0;

        // Claim Velocity (Average time to claim in hours and minutes)
        // Claim Velocity (Average time to claim query)
        $avgSeconds = Project::whereNotNull('claimed_at')
            ->whereNotNull('created_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, claimed_at)) as avg_diff')
            ->value('avg_diff');

        $avgSeconds = $avgSeconds ?: 0;
        $avgHours = floor($avgSeconds / 3600);
        $avgMinutes = floor(($avgSeconds % 3600) / 60);
        $claimVelocity = $avgSeconds > 0 ? "{$avgHours}j {$avgMinutes}m" : "N/A";

        // Completion Rate
        $completedProjects = Project::where('status', 'completed')->count();
        $completionRate = $totalProjects > 0 ? ($completedProjects / $totalProjects) * 100 : 0;

        // Admin Fee Pool YTD
        $adminFeePool = Project::whereYear('created_at', Carbon::now()->year)
            ->sum('admin_fee');

        // Hot Claims Available (for Staff only)
        $hotClaims = null;
        if ($user->isStaff()) {
            $hotClaims = Project::where('status', 'available')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        }

        // Project Status Distribution
        $statusDistribution = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Admin Funnel (Admin only)
        $funnel = null;
        if ($user->isAdmin()) {
            $funnel = [
                'created' => Project::count(),
                'claimed' => Project::whereNotNull('claimed_at')->count(),
                'completed' => Project::where('status', 'completed')->count(),
            ];
        }

        // Additional Data for Admin
        $recentProjects = null;
        $topPerformers = null;
        $monthlyStats = null;
        if ($user->isAdmin()) {
            $recentProjects = Project::with(['assignees', 'creator'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            $topPerformers = User::where('role', 'staff')
                ->orderBy('total_nett_budget', 'desc')
                ->orderBy('name', 'asc')
                ->limit(5)
                ->get();
            
            $monthlyStats = [
                'this_month' => Project::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),
                'last_month' => Project::whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year)
                    ->count(),
                'this_month_revenue' => Project::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum(Auth::user()->isStaff() ? 'nett_budget' : 'admin_fee'),
                'last_month_revenue' => Project::whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year)
                    ->sum(Auth::user()->isStaff() ? 'nett_budget' : 'admin_fee'),
            ];
        }

        // Additional Data for Staff
        $myProjects = null;
        $myStats = null;
        if ($user->isStaff()) {
            $myProjects = $user->assignedProjects()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            $myStats = [
                'in_progress' => $user->assignedProjects()
                    ->where('status', 'in_progress')
                    ->count(),
                'completed' => $user->assignedProjects()
                    ->where('status', 'completed')
                    ->count(),
                'total_earned' => $user->assignedProjects()
                    ->where('status', 'completed')
                    ->get()
                    ->sum('pivot.payout_amount'),
                'this_month_earned' => $user->assignedProjects()
                    ->where('status', 'completed')
                    ->whereMonth('projects.updated_at', Carbon::now()->month)
                    ->sum('project_user.payout_amount'),
                'last_month_earned' => $user->assignedProjects()
                    ->where('status', 'completed')
                    ->whereMonth('projects.updated_at', Carbon::now()->subMonth()->month)
                    ->sum('project_user.payout_amount'),
            ];
        }

        return view('dashboard.index', compact(
            'projectHealth',
            'claimVelocity',
            'completionRate',
            'adminFeePool',
            'hotClaims',
            'statusDistribution',
            'funnel',
            'totalProjects',
            'inProgressProjects',
            'completedProjects',
            'recentProjects',
            'topPerformers',
            'monthlyStats',
            'myProjects',
            'myStats'
        ));
    }
}
