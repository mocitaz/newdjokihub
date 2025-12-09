<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" @click.outside="open = false" class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 rounded-xl transition-all">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        
        @if($this->unreadCount > 0)
        <span class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-2xl bg-white py-1 shadow-xl ring-1 ring-black/5 focus:outline-none" 
         role="menu" 
         aria-orientation="vertical" 
         aria-labelledby="user-menu-button" 
         style="display: none;"
         tabindex="-1">
        
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <h3 class="text-sm font-bold text-gray-900">Notifications</h3>
            @if($this->unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wide">Mark all read</button>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($this->notifications as $notification)
                <div class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 {{ !$notification->read ? 'bg-blue-50/30' : '' }}">
                    <button wire:click="markAsRead({{ $notification->id }}, '{{ route('projects.show', $notification->project_id) }}')" class="w-full text-left flex gap-3">
                        <div class="flex-shrink-0 mt-1">
                            @if($notification->type === 'project_assigned')
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            @elseif($notification->type === 'project_completed')
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-900 truncate">
                                {{ $notification->title }}
                                @if(!$notification->read)
                                <span class="ml-1.5 inline-block w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">
                                {{ $notification->message }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </button>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-300">
                        <svg class="h-full w-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-xs text-gray-500">You're all caught up!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
