<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public function getUnreadCountProperty()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function getNotificationsProperty()
    {
        return Auth::user()->notifications()->latest()->take(5)->get();
    }

    public function markAsRead($notificationId, $url = null)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->update(['read' => true]);
        }

        if ($url) {
            return redirect($url);
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read' => true]);
        $this->dispatch('notifications-cleared');
    }

    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
