<footer {{ $attributes->merge(['class' => 'bg-white border-t border-slate-200 mt-auto']) }}>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Left: Copyright & Parent Company -->
            <div class="flex flex-col md:flex-row items-center gap-4 text-xs text-slate-500">
                <div class="font-medium text-slate-900">&copy; {{ date('Y') }} DjokiHub v2.0</div>
                <div class="hidden md:block w-px h-3 bg-slate-300"></div>
                <div class="flex items-center gap-1.5 hover:text-slate-800 transition-colors cursor-default">
                    <span>Subsidiary of</span>
                    <img src="{{ asset('images/teknalogi.png') }}" alt="PT. Teknalogi Transformasi Digital" class="h-4 opacity-70 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                    <span class="font-semibold tracking-tight">PT. Teknalogi Transformasi Digital</span>
                </div>
            </div>

            <!-- Right: Links -->
            <div class="flex items-center gap-6 text-xs font-semibold text-slate-500">
                <a href="{{ route('privacy') }}" class="hover:text-blue-600 transition-colors">Privacy</a>
                <a href="{{ route('terms') }}" class="hover:text-blue-600 transition-colors">Terms</a>
                <a href="{{ route('support') }}" class="hover:text-blue-600 transition-colors">Support</a>
                <div class="w-px h-3 bg-slate-300 mx-1"></div>
                <span class="text-slate-400">Jakarta, ID</span>
            </div>

        </div>
    </div>
</footer>
