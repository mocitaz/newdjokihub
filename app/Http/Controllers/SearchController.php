<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'projects' => [],
                'staff' => [],
                'wiki' => []
            ]);
        }

        // Search Projects
        $projects = Project::where('name', 'like', "%{$query}%")
            ->orWhere('order_id', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function($project) {
                return [
                    'id' => $project->id,
                    'type' => 'project',
                    'title' => $project->name,
                    'subtitle' => $project->order_id,
                    'url' => route('projects.show', $project),
                    'icon' => '📋'
                ];
            });

        // Search Staff (Admin only)
        $staff = [];
        if (auth()->user()->isAdmin()) {
            $staff = User::where('role', 'staff')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'type' => 'staff',
                        'title' => $user->name,
                        'subtitle' => $user->email,
                        'url' => route('staff.show', $user),
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
                    ];
                });
        }

        // Search Wiki (will be implemented after Wiki module)
        $wiki = [];

        return response()->json([
            'projects' => $projects,
            'staff' => $staff,
            'wiki' => $wiki
        ]);
    }
}
