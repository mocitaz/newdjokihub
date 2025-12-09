<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class StaffProjectHistory extends Component
{
    public $staffId;

    public function mount(User $staff)
    {
        $this->staffId = $staff->id;
    }

    public function getStaffProperty()
    {
        return User::find($this->staffId);
    }

    public function render()
    {
        $projects = $this->staff->assignedProjects()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('livewire.staff-project-history', [
            'projects' => $projects,
            'staff' => $this->staff
        ]);
    }
}
