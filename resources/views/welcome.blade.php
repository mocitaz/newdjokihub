<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Djokihub') }} - Enterprise Project Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        .bg-grid-slate-100 {
            background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 10s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        
        .animation-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .reveal-on-scroll { opacity: 0; transform: translateY(20px); transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); }
        .reveal-visible { opacity: 1; transform: translateY(0); }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee { animation: marquee 35s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
        
        /* Podium Animation */
        .podium-enter { animation: podium-up 1s ease-out forwards; opacity: 0; transform: translateY(50px); }
        @keyframes podium-up { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden selection:bg-blue-600 selection:text-white"
      x-data="{ scrolled: false }" 
      @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- NOISE OVERLAY -->
    <div class="fixed inset-0 pointer-events-none z-[100] opacity-[0.03] mix-blend-overlay" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg')"></div>

    <!-- NAVBAR (Existing) -->
    <!-- NAVBAR (Responsive) -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         :class="scrolled ? 'bg-white/80 backdrop-blur-md border-b border-slate-200/50 py-3 shadow-sm' : 'bg-transparent border-transparent py-5'" 
         class="fixed top-0 w-full z-50 transition-all duration-300"
         @scroll.window="scrolled = (window.pageYOffset > 20)">
        
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="DjokiHub" class="w-8 h-8 rounded-lg shadow-sm object-contain bg-white">
                <span class="font-display font-bold text-lg tracking-tight text-slate-900">DjokiHub<span class="text-blue-600">.</span></span>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <div class="flex gap-6 text-sm font-semibold text-slate-500">
                    <a href="#stats" class="hover:text-slate-900 transition-colors">Stats</a>
                    <a href="#top-3" class="hover:text-slate-900 transition-colors">Top 3</a>
                    <a href="#features" class="hover:text-slate-900 transition-colors">Features</a>
                    <a href="#rates" class="hover:text-slate-900 transition-colors">Rates</a>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-lg bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                            Login
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
            
            <a href="#stats" @click="mobileMenuOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">Stats</a>
            <a href="#top-3" @click="mobileMenuOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">Top 3</a>
            <a href="#features" @click="mobileMenuOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">Features</a>
            <a href="#rates" @click="mobileMenuOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-900 py-2">Rates</a>
            <div class="h-px bg-slate-100 my-1"></div>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center px-5 py-3 rounded-lg bg-slate-900 text-white text-sm font-bold hover:bg-slate-800">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-500/20">
                        Login to Platform
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO SECTION (Existing) -->
    <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 overflow-hidden">
        <!-- ... existing hero content ... -->
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
        <!-- Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-blue-100 rounded-full blur-3xl animate-blob mix-blend-multiply opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] bg-purple-100 rounded-full blur-3xl animate-blob animation-delay-2000 mix-blend-multiply opacity-50"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                
                <!-- Left: Copy -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-slate-200 shadow-sm mb-6 animate-fade-in-up">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">v2.0 Internal System</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-display font-extrabold tracking-tight text-slate-900 mb-6 leading-[1.1]">
                        Manage <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Proyek & Task.</span>
                    </h1>

                    <p class="text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed mb-8">
                        Centralized platform for task assignments, progress tracking, and automated payouts. Real-time metrics for real results.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-black transition-all shadow-xl shadow-slate-900/10 flex items-center justify-center gap-2">
                            Mulai Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <!-- Real User Avatars (Existing) -->
                    <!-- Social Proof (Cool) -->
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-4">
                        <div class="flex -space-x-4 hover:space-x-1 transition-all duration-300">
                            @foreach($latest_members as $member)
                            <div class="w-10 h-10 rounded-full ring-2 ring-white shadow-lg overflow-hidden relative group hover:scale-110 hover:-translate-y-1 transition-transform z-0 hover:z-10" title="{{ $member->name }}">
                                <img src="{{ $member->profile_photo_url }}" class="w-full h-full object-cover" alt="{{ $member->name }}">
                            </div>
                            @endforeach
                            @if($active_users > 5)
                            <div class="w-10 h-10 rounded-full ring-2 ring-white bg-slate-900 flex items-center justify-center text-xs font-bold text-white shadow-lg z-10">
                                +{{ $active_users - 5 }}
                            </div>
                            @endif
                        </div>
                        <div class="text-sm">
                            <div class="flex items-center gap-1 font-bold text-slate-900">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                {{ number_format($active_users) }} Active Users
                            </div>
                            <div class="text-slate-500 text-xs">contributing daily</div>
                        </div>
                    </div>
                </div>

                <!-- Right: 3D Visual (Existing) -->
                <div class="flex-1 w-full lg:w-auto relative perspective-[2000px] z-10 group">
                    <div class="relative w-full aspect-[4/3] bg-white rounded-3xl shadow-2xl border border-slate-200/60 p-2 transform rotate-y-[-8deg] rotate-x-[4deg] group-hover:rotate-0 transition-all duration-700 ease-out">
                        <div class="absolute inset-0 bg-white rounded-3xl ring-1 ring-black/5"></div>
                        <!-- Mockup Screen -->
                        <div class="bg-slate-50 rounded-[1.3rem] h-full w-full overflow-hidden relative flex flex-col border border-slate-100">
                             <div class="h-10 border-b border-slate-200 bg-white flex items-center px-4 gap-2">
                                 <div class="flex gap-1.5">
                                     <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                                     <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                                 </div>
                                 <div class="ml-4 w-24 h-1.5 bg-slate-100 rounded-full"></div>
                             </div>
                             <div class="p-5 grid grid-cols-12 gap-4 h-full">
                                 <div class="col-span-3 space-y-2">
                                     <div class="h-6 bg-blue-100 rounded-md w-full"></div>
                                     <div class="h-6 bg-white rounded-md w-full"></div>
                                     <div class="h-24 bg-slate-100 rounded-lg w-full mt-4"></div>
                                 </div>
                                 <div class="col-span-9 space-y-3">
                                     <div class="flex gap-3 mb-2">
                                         <div class="h-20 flex-1 bg-white rounded-xl shadow-sm border border-slate-100 p-3">
                                             <div class="w-6 h-6 rounded-md bg-green-100 mb-2"></div>
                                             <div class="h-1.5 w-12 bg-slate-100 rounded"></div>
                                         </div>
                                         <div class="h-20 flex-1 bg-white rounded-xl shadow-sm border border-slate-100 p-3">
                                             <div class="w-6 h-6 rounded-md bg-blue-100 mb-2"></div>
                                             <div class="h-1.5 w-12 bg-slate-100 rounded"></div>
                                         </div>
                                     </div>
                                     <div class="h-32 bg-white rounded-xl shadow-sm border border-slate-100 p-3 flex items-end justify-between gap-2 px-4 pb-2">
                                         <div class="w-full bg-blue-500 rounded-t-sm h-[40%]"></div>
                                         <div class="w-full bg-blue-400 rounded-t-sm h-[60%]"></div>
                                         <div class="w-full bg-blue-500 rounded-t-sm h-[30%]"></div>
                                         <div class="w-full bg-blue-600 rounded-t-sm h-[80%]"></div>
                                         <div class="w-full bg-blue-400 rounded-t-sm h-[50%]"></div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                        
                         <!-- Floating Badges with Icons -->
                         <div class="absolute -right-8 top-12 bg-white p-3 rounded-xl shadow-lg border border-slate-100 animation-float">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase">Total Payouts</div>
                                    <div class="text-sm font-bold text-slate-900">Rp {{ number_format($total_payouts/1000000, 1) }}M+</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LIVE PAYOUT FEED (Improved Marquee) -->
    <div class="bg-slate-950 border-y border-slate-800 py-3 overflow-hidden relative z-20">
        <div class="flex animate-marquee whitespace-nowrap items-center gap-12 min-w-full">
            <!-- Content Block 1 -->
            <div class="flex items-center gap-12 shrink-0">
                @foreach($completed_projects as $project)
                    @foreach($project->assignees as $assignee)
                        <div class="flex items-center gap-3 text-xs font-mono text-slate-400">
                            <div class="relative w-2 h-2">
                                <span class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-75"></span>
                                <span class="relative block w-2 h-2 rounded-full bg-green-500"></span>
                            </div>
                            <img src="{{ $assignee->profile_photo_url }}" class="w-5 h-5 rounded-full border border-slate-700">
                            <span class="text-white font-bold">{{ $assignee->name }}</span>
                            <span class="text-slate-500">just completed</span>
                            <span class="text-blue-400 font-bold truncate max-w-[150px]">{{ $project->name }}</span>
                            <span class="text-green-400 font-bold px-1.5 py-0.5 rounded bg-green-900/30 border border-green-900/50">Rp {{ number_format($project->nett_budget) }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
            
            <!-- Content Block 2 (Duplicate for smooth loop) -->
            <div class="flex items-center gap-12 shrink-0">
                 @foreach($completed_projects as $project)
                    @foreach($project->assignees as $assignee)
                        <div class="flex items-center gap-3 text-xs font-mono text-slate-400">
                            <div class="relative w-2 h-2">
                                <span class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-75"></span>
                                <span class="relative block w-2 h-2 rounded-full bg-green-500"></span>
                            </div>
                            <img src="{{ $assignee->profile_photo_url }}" class="w-5 h-5 rounded-full border border-slate-700">
                            <span class="text-white font-bold">{{ $assignee->name }}</span>
                            <span class="text-slate-500">just completed</span>
                            <span class="text-blue-400 font-bold truncate max-w-[150px]">{{ $project->name }}</span>
                            <span class="text-green-400 font-bold px-1.5 py-0.5 rounded bg-green-900/30 border border-green-900/50">Rp {{ number_format($project->nett_budget) }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
        
        <!-- Facades -->
        <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-slate-950 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-slate-950 to-transparent z-10 pointer-events-none"></div>
    </div>

    <!-- HALL OF FAME (Podium Redesign - Compact) -->
    <section id="top-3" class="py-16 bg-white border-b border-slate-100 relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-gradient-to-b from-yellow-50/50 to-transparent rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-10">
                <span class="text-yellow-500 font-bold tracking-widest text-xs uppercase mb-2 block">The Elite League</span>
                <h2 class="text-4xl font-extrabold text-slate-900 font-display">Hall of Fame</h2>
            </div>
            
            <div class="flex flex-col md:flex-row items-center md:items-end justify-center gap-4 md:gap-6 h-auto md:h-[350px]">
                
                <!-- #2 SILVER -->
                @if(isset($top_contributors[1]))
                <div class="order-2 md:order-1 w-full md:w-1/3 max-w-[280px] podium-enter" style="animation-delay: 0.2s">
                    <div class="relative bg-white rounded-t-3xl border-t border-x border-slate-200 shadow-xl p-5 flex flex-col items-center h-[280px] justify-end transform hover:-translate-y-1 transition-transform duration-500">
                        <!-- Rank Badge -->
                        <div class="absolute -top-4 w-8 h-8 rounded-full bg-slate-200 border-4 border-white shadow-sm flex items-center justify-center font-bold text-slate-600 z-20 text-sm">2</div>
                        
                        <!-- Avatar -->
                        <div class="mb-3 relative">
                             <div class="w-16 h-16 rounded-full border-4 border-slate-100 shadow-inner overflow-hidden">
                                <img src="{{ $top_contributors[1]->profile_photo_url }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <div class="text-center mb-3">
                            <h3 class="font-bold text-slate-900 text-base line-clamp-1">{{ $top_contributors[1]->name }}</h3>
                            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Silver Contributor</div>
                        </div>
                        
                        <div class="w-full bg-slate-50/50 rounded-xl p-3 border border-slate-100 text-center">
                            <div class="text-xl font-black text-slate-700 font-mono">{{ $top_contributors[1]->projects_count }}</div>
                            <div class="text-[9px] text-slate-400 uppercase font-bold">Projects Shipped</div>
                        </div>
                        
                        <!-- Base -->
                        <div class="absolute bottom-0 inset-x-0 h-2 bg-slate-300"></div>
                    </div>
                </div>
                @endif

                <!-- #1 GOLD -->
                @if(isset($top_contributors[0]))
                <div class="order-1 md:order-2 w-full md:w-1/3 max-w-[320px] relative z-10 podium-enter mb-8 md:mb-0">
                    <!-- Crown -->
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 animate-bounce">
                        <svg class="w-10 h-10 text-yellow-400 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>

                    <div class="relative bg-white rounded-t-3xl border-t border-x border-orange-100 shadow-2xl p-6 flex flex-col items-center h-[340px] justify-end transform hover:-translate-y-1 transition-transform duration-500 ring-1 ring-orange-100">
                         <!-- Glow -->
                         <div class="absolute inset-0 bg-gradient-to-b from-yellow-50/80 to-transparent rounded-t-3xl pointer-events-none"></div>

                        <!-- Rank Badge -->
                        <div class="absolute -top-5 w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 border-4 border-white shadow-lg flex items-center justify-center font-bold text-white z-20 text-lg">1</div>
                        
                        <!-- Avatar -->
                        <div class="mb-5 relative z-10">
                            <div class="absolute inset-0 bg-yellow-400 rounded-full blur-md opacity-40"></div>
                             <div class="w-24 h-24 rounded-full border-4 border-white shadow-xl overflow-hidden relative">
                                <img src="{{ $top_contributors[0]->profile_photo_url }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <div class="text-center mb-5 relative z-10">
                            <h3 class="font-bold text-slate-900 text-lg md:text-xl line-clamp-1">{{ $top_contributors[0]->name }}</h3>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 border border-yellow-200 mt-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                <span class="text-yellow-700 text-[9px] font-bold uppercase tracking-wider">MVP Developer</span>
                            </div>
                        </div>
                        
                        <div class="w-full bg-white/80 backdrop-blur-sm rounded-xl p-3 border border-yellow-100 text-center shadow-inner relative z-10">
                            <div class="text-2xl font-black text-slate-900 font-mono">{{ $top_contributors[0]->projects_count }}</div>
                            <div class="text-[9px] text-slate-400 uppercase font-bold">Projects Shipped</div>
                        </div>
                        
                        <!-- Base -->
                        <div class="absolute bottom-0 inset-x-0 h-3 bg-gradient-to-r from-yellow-400 to-orange-400"></div>
                    </div>
                </div>
                @endif
                
                <!-- #3 BRONZE -->
                @if(isset($top_contributors[2]))
                <div class="order-3 md:order-3 w-full md:w-1/3 max-w-[280px] podium-enter" style="animation-delay: 0.4s">
                    <div class="relative bg-white rounded-t-3xl border-t border-x border-slate-200 shadow-xl p-5 flex flex-col items-center h-[250px] justify-end transform hover:-translate-y-1 transition-transform duration-500">
                        <!-- Rank Badge -->
                        <div class="absolute -top-4 w-8 h-8 rounded-full bg-orange-100 border-4 border-white shadow-sm flex items-center justify-center font-bold text-orange-800 z-20 text-sm">3</div>
                        
                        <!-- Avatar -->
                        <div class="mb-3 relative">
                             <div class="w-16 h-16 rounded-full border-4 border-slate-100 shadow-inner overflow-hidden">
                                <img src="{{ $top_contributors[2]->profile_photo_url }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        <div class="text-center mb-3">
                            <h3 class="font-bold text-slate-900 text-base line-clamp-1">{{ $top_contributors[2]->name }}</h3>
                            <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Bronze Contributor</div>
                        </div>
                        
                        <div class="w-full bg-slate-50/50 rounded-xl p-3 border border-slate-100 text-center">
                            <div class="text-xl font-black text-slate-700 font-mono">{{ $top_contributors[2]->projects_count }}</div>
                            <div class="text-[9px] text-slate-400 uppercase font-bold">Projects Shipped</div>
                        </div>
                        
                        <!-- Base -->
                        <div class="absolute bottom-0 inset-x-0 h-2 bg-orange-300"></div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>

    <!-- REAL STATS (Existing) -->
    <section id="stats" class="py-16 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-slate-800">
                 <div class="p-2" x-data="{ shown: false }" x-intersect="shown = true">
                     <div class="text-3xl md:text-4xl font-extrabold mb-1 font-display" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" class="transition-all duration-700">
                         {{ number_format($total_claims) }}
                     </div>
                     <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Claims</div>
                 </div>
                 <div class="p-2" x-data="{ shown: false }" x-intersect="shown = true">
                     <div class="text-3xl md:text-4xl font-extrabold mb-1 font-display" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" class="transition-all duration-700 delay-100">
                         {{ number_format($active_users) }}
                     </div>
                     <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active Members</div>
                 </div>
                 <div class="p-2" x-data="{ shown: false }" x-intersect="shown = true">
                     <div class="text-3xl md:text-4xl font-extrabold mb-1 font-display" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" class="transition-all duration-700 delay-200">
                         {{ number_format($total_payouts/1000000, 1) }}M+
                     </div>
                     <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Paid Out</div>
                 </div>
                 <div class="p-2" x-data="{ shown: false }" x-intersect="shown = true">
                     <div class="text-3xl md:text-4xl font-extrabold mb-1 font-display" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" class="transition-all duration-700 delay-300">
                         Rp {{ number_format($avg_payout/1000, 0) }}K
                     </div>
                     <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Avg. Payout</div>
                 </div>
            </div>
        </div>
    </section>

    <!-- BENTO GRID (Existing) -->
    <section id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-4xl font-extrabold text-slate-900 mb-4 font-display">System Capabilities</h2>
                <p class="text-lg text-slate-500">Everything you need to ship projects faster.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Feature -->
                <div class="col-span-1 md:col-span-2 bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 relative overflow-hidden group hover:border-blue-100 transition-colors duration-500">
                    <div class="relative z-10 flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-1">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-3">Real-time Analytics</h3>
                            <p class="text-slate-500 leading-relaxed text-base">Track your project velocity, total earnings, and personal growth in real-time. Our dashboard provides transparent metrics so you always know where you stand.</p>
                        </div>
                        <div class="flex-1 w-full bg-white rounded-2xl shadow-sm border border-slate-200 h-40 p-5 transform group-hover:scale-105 transition-transform duration-500">
                            <div class="flex items-end justify-between h-full gap-3">
                                <div class="w-full bg-slate-100 rounded-md h-[40%] group-hover:bg-blue-100 transition-colors"></div>
                                <div class="w-full bg-slate-100 rounded-md h-[70%] group-hover:bg-blue-200 transition-colors"></div>
                                <div class="w-full bg-blue-600 rounded-md h-[50%] shadow-lg shadow-blue-600/20"></div>
                                <div class="w-full bg-slate-100 rounded-md h-[80%] group-hover:bg-blue-100 transition-colors"></div>
                                <div class="w-full bg-slate-100 rounded-md h-[60%] group-hover:bg-blue-50 transition-colors"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wiki -->
                <div class="bg-slate-900 rounded-[2.5rem] p-10 border border-slate-800 relative overflow-hidden group text-white">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-48 h-48 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-300 flex items-center justify-center mb-6 ring-1 ring-purple-500/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 relative z-10">Internal Wiki</h3>
                    <p class="text-slate-400 relative z-10 leading-relaxed">Stop asking repetitive questions. Access our centralized documentation hub for guidelines, assets, and best practices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS (Updated) -->
    <section class="py-24 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                 <h2 class="text-4xl font-extrabold text-slate-900 mb-4 font-display">Developer Stories</h2>
                 <p class="text-lg text-slate-500">Hear from the team building the future.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $quotes = [
                        "Awalnya skeptis, tapi sistem DjokiHub beneran seamless. Mulai dari ambil task, submit progress, sampai payment cair cuma butuh waktu kurang dari 24 jam. UI-nya juga clean banget, nggak bikin sakit mata pas coding malem-malem.",
                        "Sebagai mahasiswa, ini life-saver banget. Bisa ngerjain project sesuai skill (Laravel/React) di sela-sela kuliah. Pembagian fee-nya transparan, admin fee-nya masuk akal, dan paling penting: nggak ada drama 'client kabur'.",
                        "Suka banget sama fitur Leaderboard-nya, bikin makin semangat push rank. Dokumentasi/Wiki-nya juga lengkap, jadi pas onboarding project baru nggak perlu tanya-tanya lagi. Solid ecosystem for developers sangat seru!",
                        "Gak nyangka platform internal bisa se-advance ini. Task center-nya rapi, brief jelas, dan yang paling oke itu feedback loop-nya cepet. Skill saya berkembang pesat sejak gabung di sini.",
                        "Enaknya di DjokiHub itu fleksibel. Mau ambil task kecil (fix bug) atau task besar (modul), semua ada rate card-nya. Transparan banget deh pokoknya. Admin fee 5% juga masih wajar banget dibanding platform luar.",
                        "Komunitasnya suportif banget. Kalau stuck ada Wiki dan senior dev yang siap bantu. Sistem deployment-nya juga modern, udah pake CI/CD, jadi kita bisa fokus coding aja."
                    ];
                @endphp
                
                @foreach($testimonial_users as $index => $user)
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <!-- Quote Icon -->
                    <div class="mb-6 opacity-20">
                         <svg class="w-10 h-10 text-slate-900" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.082 15.464 15 17.141 15C17.846 15 18.29 15.148 18.667 15.309C18.667 15.309 17.141 11.238 17.518 10C17.518 10 20.329 10.375 22 12V21H14.017ZM8 21L8 18C8 16.082 9.467 15 11.125 15C11.83 15 12.274 15.148 12.651 15.309C12.651 15.309 11.125 11.238 11.502 10C11.502 10 14.312 10.375 16 12V21H8Z" transform="translate(-8 -4)"/></svg>
                    </div>
                    
                    <p class="text-slate-600 mb-8 leading-loose text-[15px]">"{{ $quotes[$index % 3] }}"</p>
                    
                    <div class="flex items-center gap-4 pt-6 border-t border-slate-50">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-slate-200 overflow-hidden ring-2 ring-white shadow-md">
                                <img src="{{ $user->profile_photo_url }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Verified Badge -->
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center text-white" title="Verified Member">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500 font-bold uppercase tracking-wide">{{ $user->program_study ?? 'Senior Developer' }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TECH ECOSYSTEM (Marquee) -->
    <section class="py-20 bg-white border-b border-slate-100 overflow-hidden">
        <div class="text-center mb-10">
            <span class="text-slate-400 font-bold tracking-widest text-xs uppercase">Powering Our Stack</span>
        </div>
        
        <div class="flex animate-marquee whitespace-nowrap items-center gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
             <!-- Logos Block 1 -->
             <div class="flex items-center gap-16 shrink-0">
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#FF2D20]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg> Laravel</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#41B883]" viewBox="0 0 24 24" fill="currentColor"><path d="M2 3h4l6 10.4L18 3h4L12 21 2 3z"/></svg> Vue.js</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#06B6D4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg> Tailwind</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#777BB4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l9 4v12l-9 4-9-4V6l9-4z"/></svg> PHP 8.2</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#4479A1]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg> MySQL</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#2496ED]" viewBox="0 0 24 24" fill="currentColor"><path d="M2 6l10-4 10 4v12l-10 4-10-4V6z"/></svg> Docker</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#FF9900]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg> AWS</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#F05032]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg> Git</span>
             </div>
             
             <!-- Logos Block 2 (Duplicate) -->
             <div class="flex items-center gap-16 shrink-0">
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#FF2D20]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg> Laravel</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#41B883]" viewBox="0 0 24 24" fill="currentColor"><path d="M2 3h4l6 10.4L18 3h4L12 21 2 3z"/></svg> Vue.js</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#06B6D4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg> Tailwind</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#777BB4]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l9 4v12l-9 4-9-4V6l9-4z"/></svg> PHP 8.2</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#4479A1]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg> MySQL</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#2496ED]" viewBox="0 0 24 24" fill="currentColor"><path d="M2 6l10-4 10 4v12l-10 4-10-4V6z"/></svg> Docker</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#FF9900]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg> AWS</span>
                 <span class="text-2xl font-bold font-display flex items-center gap-2"><svg class="w-8 h-8 text-[#F05032]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg> Git</span>
             </div>
        </div>
    </section>

    <!-- RATES (Compact & Cool) -->
    <section id="rates" class="py-16 bg-white relative border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 font-display">Standard Rates</h2>
                    <p class="text-slate-500 mt-1">Simple, transparent pricing. No hidden fees.</p>
                </div>
                <a href="#" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    View Full Rate Card <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Bug Fixes -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-blue-50 transition-colors">
                            <svg class="w-5 h-5 text-slate-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Bug Fixes</h3>
                    <div class="my-3 flex items-baseline gap-1">
                        <span class="text-2xl font-black font-mono text-slate-900">150K</span>
                        <span class="text-xs text-slate-500 font-bold uppercase">/ task</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed">Quick fixes for layout issues, logic errors, or small styling tweaks.</p>
                    <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold group-hover:border-blue-200 group-hover:bg-blue-50 group-hover:text-blue-600 transition-all">
                        Details
                    </a>
                </div>

                <!-- Card 2: Feature Module (Popular) -->
                <div class="relative bg-slate-900 rounded-2xl p-6 shadow-xl ring-1 ring-slate-900 transform md:-translate-y-2 z-10">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-20"></div>
                    
                    <div class="relative h-full flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                             <div class="p-2 bg-blue-500/20 rounded-lg">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="bg-blue-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Popular</span>
                        </div>
                        <h3 class="text-lg font-bold text-white">Feature Module</h3>
                        <div class="my-3 flex items-baseline gap-1">
                            <span class="text-2xl font-black font-mono text-white">1.5M</span>
                            <span class="text-xs text-slate-400 font-bold uppercase">/ module</span>
                        </div>
                        <p class="text-xs text-slate-400 mb-6 leading-relaxed">Complete CRUD module, complex forms, or dashboard widgets.</p>
                        <a href="{{ route('login') }}" class="mt-auto w-full flex justify-center items-center py-2.5 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-500 transition-colors shadow-lg shadow-blue-900/50">
                            Start Building
                        </a>
                    </div>
                </div>

                <!-- Card 3: Full Project -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200 hover:border-indigo-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-slate-100 rounded-lg group-hover:bg-indigo-50 transition-colors">
                            <svg class="w-5 h-5 text-slate-600 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Full Project</h3>
                    <div class="my-3 flex items-baseline gap-1">
                        <span class="text-2xl font-black font-mono text-slate-900">8.0M</span>
                        <span class="text-xs text-slate-500 font-bold uppercase">/ project</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed">End-to-end development. From DB design to deployment.</p>
                    <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold group-hover:border-indigo-200 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all">
                        Details
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPARISON TABLE (Modern Compact) -->
    <section class="py-16 bg-slate-50 border-y border-slate-200">
        <div class="max-w-4xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div class="text-left">
                    <h2 class="text-3xl font-extrabold text-slate-900 font-display mb-3">Why DjokiHub?</h2>
                    <p class="text-slate-500 mb-6 leading-relaxed">The superior choice for internal development. Stop wasting time with unreliable vendors and opaque pricing.</p>
                     <div class="flex gap-4">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-600">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div> Internal
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                            <div class="w-2 h-2 rounded-full bg-slate-300"></div> Agency
                        </div>
                    </div>
                </div>
                
                <!-- Table Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden text-sm">
                    <div class="grid grid-cols-3 bg-slate-50 border-b border-slate-100 p-4 font-bold text-slate-700">
                        <div>Feature</div>
                        <div class="text-center text-blue-600">DjokiHub</div>
                        <div class="text-center text-slate-400">Agency</div>
                    </div>
                    
                    <!-- Rows -->
                    <div class="divide-y divide-slate-50">
                        <div class="grid grid-cols-3 p-4 hover:bg-slate-50/50 transition-colors items-center">
                            <div class="font-bold text-slate-700 text-xs uppercase tracking-wide">Payment Spread</div>
                            <div class="text-center font-bold text-slate-900">Instant / Weekly</div>
                            <div class="text-center text-slate-400 text-xs">Net-30 / Net-60</div>
                        </div>
                        
                        <div class="grid grid-cols-3 p-4 hover:bg-slate-50/50 transition-colors items-center">
                            <div class="font-bold text-slate-700 text-xs uppercase tracking-wide">Admin Fee</div>
                            <div class="text-center">
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">5% (Transparent)</span>
                            </div>
                            <div class="text-center text-slate-400 text-xs">30-50% (Opaque)</div>
                        </div>
                        
                        <div class="grid grid-cols-3 p-4 hover:bg-slate-50/50 transition-colors items-center">
                            <div class="font-bold text-slate-700 text-xs uppercase tracking-wide">Activity</div>
                            <div class="text-center font-bold text-slate-900">Daily Updates</div>
                            <div class="text-center text-slate-400 text-xs">Inconsistent</div>
                        </div>
                        
                        <div class="grid grid-cols-3 p-4 hover:bg-slate-50/50 transition-colors items-center">
                            <div class="font-bold text-slate-700 text-xs uppercase tracking-wide">Management</div>
                            <div class="text-center flex justify-center">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-center flex justify-center">
                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ (Side-by-Side Compact) -->
    <section class="py-24 bg-white border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-20">
                <!-- Header (Sticky) -->
                <div class="lg:col-span-4 lg:sticky lg:top-32 h-fit text-center lg:text-left">
                    <span class="text-blue-600 font-bold tracking-widest text-xs uppercase mb-2 block">Support</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-4 font-display">FAQs</h2>
                    <p class="text-slate-500 leading-relaxed mb-6">Everything you need to know about the product and billing.</p>
                    
                    <a href="mailto:support@djokihub.com" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 border-b-2 border-slate-200 hover:border-blue-600 pb-0.5 transition-colors">
                        Contact Support <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                
                <!-- Accordion List -->
                <div class="lg:col-span-8">
                    <div class="divide-y divide-slate-100" x-data="{ active: null }">
                        
                        <!-- Item 1 -->
                        <div class="py-5" x-data="{ id: 1 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">How do I join?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    DjokiHub is currently invite-only. Please contact your internal manager or HR to request access credentials. We onboard new developers in cohorts every month to ensure quality control.
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="py-5" x-data="{ id: 2 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">Is there a minimum payout?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    No minimum threshold. Once your task is approved (`status: completed`), the funds are transferred to your wallet instantly. You can withdraw to your local bank account anytime via the dashboard.
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="py-5" x-data="{ id: 3 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">Can I work on weekends?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    Absolutely. The platform is open 24/7. Claims are processed automatically based on availability, so you can pick up tasks whenever it suits your schedule, including weekends and holidays.
                                </div>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="py-5" x-data="{ id: 4 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">What happens if I miss a deadline?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    You must request an extension via the dashboard at least 24 hours prior. Failure to do so may result in the claim being revoked. Repeated missed deadlines will impact your reliability score.
                                </div>
                            </div>
                        </div>

                        <!-- Item 5 -->
                        <div class="py-5" x-data="{ id: 5 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">How are taxes handled?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    As an internal contractor platform, you are responsible for your own tax reporting in accordance with local laws. We provide a downloadable monthly earnings summary to assist with your filing.
                                </div>
                            </div>
                        </div>

                        <!-- Item 6 -->
                        <div class="py-5" x-data="{ id: 6 }">
                            <button @click="active = (active === id ? null : id)" class="flex justify-between items-center w-full group text-left">
                                <span class="text-lg font-bold text-slate-900 transition-colors group-hover:text-blue-600" :class="active === id ? 'text-blue-600' : ''">Is the code open source?</span>
                                <span class="ml-6 flex items-center pr-2">
                                    <svg class="h-5 w-5 transform transition-transform duration-300 text-slate-400" :class="active === id ? 'rotate-180 text-blue-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="active === id" x-collapse>
                                <div class="mt-3 text-slate-500 text-[15px] leading-relaxed pr-12">
                                    No. All code pushed to the DjokiHub repositories is proprietary property of PT. Teknalogi Transformasi Digital and is protected by strict NDAs. Unauthorized sharing is prohibited.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER (Reverted to Original) -->
    <!-- FOOTER (Reverted to Original) -->
    <x-footer class="bg-white/80 backdrop-blur-xl border-t border-slate-200 mt-auto" />

</body>
</html>
