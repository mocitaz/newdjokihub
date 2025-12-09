<span>
    @if($availableCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse z-10">
            {{ $availableCount > 9 ? '9+' : $availableCount }}
        </span>
    @endif
</span>
