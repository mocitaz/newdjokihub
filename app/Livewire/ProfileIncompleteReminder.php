<?php

namespace App\Livewire;

use Livewire\Component;

class ProfileIncompleteReminder extends Component
{
    public $showModal = false;
    public $missingFields = [];

    public function mount()
    {
        if (auth()->check()) {
            // Don't show on profile pages
            if (request()->routeIs('profile.*')) {
                return;
            }

            // Check if we've already shown the reminder in this session
            if (session()->has('has_seen_profile_reminder')) {
                return;
            }

            $this->missingFields = auth()->user()->getMissingProfileFields();
            if (!empty($this->missingFields)) {
                $this->showModal = true;
            }
        }
    }

    public function updateProfile()
    {
        session()->put('has_seen_profile_reminder', true);
        return redirect()->route('profile.edit');
    }

    public function remindLater()
    {
        session()->put('has_seen_profile_reminder', true);
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.profile-incomplete-reminder');
    }
}
