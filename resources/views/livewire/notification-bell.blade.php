<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors relative">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if($unreadCount > 0)
        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 max-h-96 overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Notifications</h3>
            <div class="flex items-center space-x-2">
                @if($unreadCount > 0)
                <button wire:click="markAllAsRead" @click.stop class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                    Mark all as read
                </button>
                @endif
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="overflow-y-auto max-h-80">
            @if(count($notifications) > 0)
                @foreach($notifications as $notification)
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notification['read'] ? 'bg-blue-50' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $notification['title'] }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $notification['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</p>
                        </div>
                        @if(!$notification['read'])
                        <button wire:click="markAsRead({{ $notification['id'] }})" @click.stop class="ml-2 text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
            <div class="p-8 text-center text-gray-500">
                <p>No notifications</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:init', () => {
    const componentId = @js($this->getId());
    
    // Auto-refresh notifications every 5 seconds
    setInterval(() => {
        if (window.Livewire) {
            const component = Livewire.find(componentId);
            if (component && typeof component.call === 'function') {
                component.call('loadNotifications');
            }
        }
    }, 5000);
});
</script>
