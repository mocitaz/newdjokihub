<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ClaimCenterBadge extends Component
{
    public function render()
    {
        $availableCount = Project::where('status', 'available')->count();
        
        return view('livewire.claim-center-badge', compact('availableCount'));
    }
}
