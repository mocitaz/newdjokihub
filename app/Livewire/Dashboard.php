<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // --- Shared Stats ---
        
        // Project Health
        $totalProjects = Project::count();
        $inProgressProjects = Project::where('status', 'in_progress')->count();
        $projectHealth = $totalProjects > 0 ? ($inProgressProjects / $totalProjects) * 100 : 0;

        // Claim Velocity
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

        // Project Status Distribution
        $statusDistribution = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // --- Role Specific Data ---

        $hotClaims = null;
        $funnel = null;
        $recentProjects = null;
        $topPerformers = null;
        $monthlyStats = null;
        $myProjects = null;
        $myStats = null;

        if ($user->isStaff()) {
            // Hot Claims
            $hotClaims = Project::where('status', 'available')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            // My Projects
            $myProjects = $user->assignedProjects()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // My Stats
            $myStats = [
                'in_progress' => $user->assignedProjects()->where('status', 'in_progress')->count(),
                'completed' => $user->assignedProjects()->where('status', 'completed')->count(),
                'total_earned' => $user->assignedProjects()->where('status', 'completed')->get()->sum('pivot.payout_amount'),
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

        if ($user->isAdmin()) {
            // Funnel
            $funnel = [
                'created' => Project::count(),
                'claimed' => Project::whereNotNull('claimed_at')->count(),
                'completed' => Project::where('status', 'completed')->count(),
            ];

            // Recent Projects
            $recentProjects = Project::with(['assignees', 'creator'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Top Performers
            $topPerformers = User::where('role', 'staff')
                ->orderBy('total_nett_budget', 'desc')
                ->orderBy('name', 'asc')
                ->limit(5)
                ->get();
            
            // Monthly Stats
            $monthlyStats = [
                'this_month' => Project::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count(),
                'last_month' => Project::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->subMonth()->year)->count(),
                'this_month_revenue' => Project::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('admin_fee'),
                'last_month_revenue' => Project::whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year)
                    ->sum('admin_fee'),
            ];
        }

        return view('livewire.dashboard', compact(
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
            'myStats',
            'user'
        ));
    }
}
