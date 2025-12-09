<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotificationsCount();
            $this->notifications = auth()->user()
                ->notifications()
                ->with('project')
                ->limit(10)
                ->get()
                ->toArray();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id === auth()->id()) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->where('read', false)->update(['read' => true]);
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
