<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;

class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::with(['assignees', 'creator'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('order_id', 'like', '%' . $this->search . '%')
                  ->orWhere('client_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.project-list', [
            'projects' => $query->paginate(15)
        ]);
    }
}
