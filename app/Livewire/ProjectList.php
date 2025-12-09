<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;

class ProjectList extends Component
{
    use WithPagination;

    public function render()
    {
        $projects = Project::with(['assignees', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.project-list', [
            'projects' => $projects
        ]);
    }
}
