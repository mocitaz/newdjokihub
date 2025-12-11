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

    <!-- Navbar (Responsive) -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         :class="scrolled ? 'bg-white/80 backdrop-blur-md border-b border-slate-200/60 shadow-sm' : 'bg-transparent border-transparent'" 
         class="fixed top-0 w-full z-50 transition-all duration-300">
        
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="DjokiHub Logo" class="w-9 h-9 rounded-xl shadow-md object-contain bg-white">
                <span class="font-bold text-xl tracking-tight text-slate-900">DjokiHub<span class="text-blue-600">.</span></span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <div class="flex gap-8 text-sm font-semibold text-slate-500">
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

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 hover:text-slate-900 focus:outline-none">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="mobileMenuOpen = false"
             class="md:hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-xl py-4 px-6 flex flex-col gap-4">
            
            <a href="{{ route('home') }}#how-it-works" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">How it Works</a>
            <a href="{{ route('home') }}#rates" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">Standard Rates</a>
            <a href="{{ route('home') }}#faq" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">FAQ</a>
            <div class="h-px bg-slate-100 my-1"></div>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center px-5 py-3 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-500/20">
                        Member Login
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <x-footer />

</body>
</html>
