<div class="relative" x-data="{ open: false }" x-init="$watch('open', value => { if (!value) { $wire.set('showResults', false); } })">
    <button @click="open = !open" class="p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </button>

    <!-- Search Overlay -->
    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="query"
                    placeholder="Search Projects, Staff, Wiki..." 
                    class="flex-1 outline-none text-sm"
                    @focus="open = true"
                    autofocus>
                @if($query)
                <button wire:click="clearSearch" @click.stop class="text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                @endif
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto" x-show="open">
            @if(strlen($query) >= 2)
                @if(count($results['projects']) > 0 || count($results['staff']) > 0 || count($results['wiki']) > 0)
                    <!-- Projects Results -->
                    @if(count($results['projects']) > 0)
                    <div class="p-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase px-3 py-2">Projects</p>
                        @foreach($results['projects'] as $result)
                        <a href="{{ $result['url'] }}" @click="open = false" class="block px-3 py-2 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-400">{!! $result['icon'] !!}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $result['title'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $result['subtitle'] }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Staff Results -->
                    @if(count($results['staff']) > 0)
                    <div class="p-2 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase px-3 py-2">Staff</p>
                        @foreach($results['staff'] as $result)
                        <a href="{{ $result['url'] }}" @click="open = false" class="block px-3 py-2 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-400">{!! $result['icon'] !!}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $result['title'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $result['subtitle'] }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Wiki Results -->
                    @if(count($results['wiki']) > 0)
                    <div class="p-2 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase px-3 py-2">Wiki</p>
                        @foreach($results['wiki'] as $result)
                        <a href="{{ $result['url'] }}" @click="open = false" class="block px-3 py-2 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-400">{!! $result['icon'] !!}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $result['title'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $result['subtitle'] }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-sm">No results found for "{{ $query }}"</p>
                </div>
                @endif
            @elseif(strlen($query) > 0 && strlen($query) < 2)
            <div class="p-8 text-center text-gray-500">
                <p class="text-sm">Type at least 2 characters to search</p>
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <p class="text-sm">Start typing to search...</p>
            </div>
            @endif
        </div>
    </div>
</div>
