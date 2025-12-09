<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\WikiArticle;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->performSearch();
    }

    public function closeSearch()
    {
        $this->showResults = false;
        $this->query = '';
        $this->results = [];
    }

    public function performSearch()
    {
        $results = [
            'projects' => [],
            'staff' => [],
            'wiki' => []
        ];

        // Search Projects
        $projects = Project::where('name', 'like', "%{$this->query}%")
            ->orWhere('order_id', 'like', "%{$this->query}%")
            ->orWhere('description', 'like', "%{$this->query}%")
            ->limit(5)
            ->get()
            ->map(function($project) {
                return [
                    'id' => $project->id,
                    'type' => 'project',
                    'title' => $project->name,
                    'subtitle' => $project->order_id,
                    'url' => route('projects.show', $project),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>',
                ];
            });

        $results['projects'] = $projects->toArray();

        // Search Staff (Admin only)
        if (auth()->check() && auth()->user()->isAdmin()) {
            $staff = User::where('role', 'staff')
                ->where(function($q) {
                    $q->where('name', 'like', "%{$this->query}%")
                      ->orWhere('email', 'like', "%{$this->query}%");
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
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                    ];
                });

            $results['staff'] = $staff->toArray();
        }

        // Search Wiki
        $wiki = WikiArticle::where('is_published', true)
            ->where(function($q) {
                $q->where('title', 'like', "%{$this->query}%")
                  ->orWhere('content', 'like', "%{$this->query}%")
                  ->orWhere('category', 'like', "%{$this->query}%");
            })
            ->limit(5)
            ->get()
            ->map(function($article) {
                return [
                    'id' => $article->id,
                    'type' => 'wiki',
                    'title' => $article->title,
                    'subtitle' => $article->category ?? 'Uncategorized',
                    'url' => route('wiki.show', $article->slug),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                ];
            });

        $results['wiki'] = $wiki->toArray();

        $this->results = $results;
        $this->showResults = true;
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
