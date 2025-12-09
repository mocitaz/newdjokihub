<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'DjokiHub'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .bg-grid-slate-100 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(241 245 249)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden selection:bg-blue-100 selection:text-blue-900 flex flex-col min-h-screen" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="scrolled ? 'bg-white/80 backdrop-blur-md border-b border-slate-200/60 shadow-sm' : 'bg-transparent border-transparent'" class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="DjokiHub Logo" class="w-9 h-9 rounded-xl shadow-md object-contain bg-white">
                <span class="font-bold text-xl tracking-tight text-slate-900">DjokiHub<span class="text-blue-600">.</span></span>
            </a>
            
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-500">
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-slate-900 transition-colors">How it Works</a>
                    <a href="{{ route('home') }}#rates" class="hover:text-slate-900 transition-colors">Standard Rates</a>
                    <a href="{{ route('home') }}#faq" class="hover:text-slate-900 transition-colors">FAQ</a>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm overflow-hidden shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all">
                            <span class="relative z-10">Member Login</span>
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
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
                    <a href="{{ route('privacy') }}" class="hover:text-amber-600 transition-colors">Privacy</a>
                    <a href="{{ route('terms') }}" class="hover:text-amber-600 transition-colors">Terms</a>
                    <a href="{{ route('support') }}" class="hover:text-amber-600 transition-colors">Support</a>
                    <div class="w-px h-3 bg-slate-300 mx-1"></div>
                    <span class="text-slate-400">Jakarta, ID</span>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>
