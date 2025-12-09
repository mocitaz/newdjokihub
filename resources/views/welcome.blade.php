<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Djokihub') }} - Enterprise Project Management</title>
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
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee { animation: marquee 40s linear infinite; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased overflow-x-hidden selection:bg-blue-100 selection:text-blue-900" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="scrolled ? 'bg-white/80 backdrop-blur-md border-b border-slate-200/60 shadow-sm' : 'bg-transparent border-transparent'" class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="DjokiHub Logo" class="w-9 h-9 rounded-xl shadow-md object-contain bg-white">
                <span class="font-bold text-xl tracking-tight text-slate-900">DjokiHub<span class="text-blue-600">.</span></span>
            </div>
            
            <div class="flex items-center gap-8">
                <div class="hidden md:flex gap-8 text-sm font-semibold text-slate-500">
                    <a href="#how-it-works" class="hover:text-slate-900 transition-colors">How it Works</a>
                    <a href="#rates" class="hover:text-slate-900 transition-colors">Standard Rates</a>
                    <a href="#faq" class="hover:text-slate-900 transition-colors">FAQ</a>
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

    <!-- HERO -->
    <div class="relative min-h-[92vh] flex flex-col justify-center pt-20 overflow-hidden bg-grid-slate-100">
        <!-- Floating Blobs -->
        <div class="absolute top-0 -left-4 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

        <div class="max-w-7xl mx-auto px-6 w-full relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="text-center lg:text-left pt-10 lg:pt-0">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Internal System v2.0</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-[1.1]">
                    Professional <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Project Management</span> <br>
                    Simplified.
                </h1>

                <p class="text-lg text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed mb-10">
                    A centralized platform for managing assignments, tracking progress, and automated billing. Designed for clarity, tailored for productivity.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10 flex items-center justify-center gap-2">
                        Get Started
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#how-it-works" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all flex items-center justify-center">
                        Learn Process
                    </a>
                </div>

                <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 text-slate-400 grayscale opacity-60">
                    <!-- Fake Partner Logos for Trust -->
                    <div class="font-bold text-xl">Laravel</div>
                    <div class="font-bold text-xl">Alpine</div>
                    <div class="font-bold text-xl">Tailwind</div>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <div class="relative lg:h-[600px] flex items-center justify-center perspective-[2000px]">
                <div class="relative w-full aspect-[4/3] bg-white rounded-3xl shadow-2xl border border-slate-200 p-2 transform rotate-y-[-12deg] rotate-x-[5deg] hover:rotate-0 transition-all duration-700">
                    <div class="absolute inset-0 bg-white rounded-3xl ring-1 ring-slate-900/5"></div>
                    <div class="bg-slate-50 rounded-2xl h-full w-full overflow-hidden relative flex flex-col">
                        <!-- Header Mockup -->
                        <div class="h-10 border-b border-slate-200 bg-white flex items-center px-4 gap-2">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                            </div>
                            <div class="ml-4 w-32 h-4 bg-slate-100 rounded-full"></div>
                        </div>
                        <!-- UI Content -->
                        <div class="p-6 grid grid-cols-3 gap-6">
                            <div class="col-span-2 space-y-4">
                                <div class="h-32 bg-white rounded-xl shadow-sm border border-slate-100 p-4">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    </div>
                                    <div class="h-2 w-24 bg-slate-100 rounded mb-2"></div>
                                    <div class="h-8 w-32 bg-slate-900 rounded-lg"></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-12 bg-white rounded-lg border border-slate-100 shadow-sm flex items-center px-3 gap-3">
                                        <div class="w-6 h-6 rounded bg-indigo-100"></div>
                                        <div class="flex-1 h-2 bg-slate-100 rounded"></div>
                                        <div class="w-12 h-6 bg-green-100 rounded text-green-700 text-[10px] font-bold flex items-center justify-center">PAID</div>
                                    </div>
                                    <div class="h-12 bg-white rounded-lg border border-slate-100 shadow-sm flex items-center px-3 gap-3">
                                        <div class="w-6 h-6 rounded bg-purple-100"></div>
                                        <div class="flex-1 h-2 bg-slate-100 rounded"></div>
                                        <div class="w-12 h-6 bg-blue-100 rounded text-blue-700 text-[10px] font-bold flex items-center justify-center">WIP</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full border-4 border-slate-50 border-t-blue-500 mb-4"></div>
                                <div class="h-2 w-16 bg-slate-100 rounded mb-2"></div>
                                <div class="h-2 w-10 bg-slate-100 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TECH MARQUEE -->
    <div class="bg-slate-50 py-10 border-y border-slate-100 overflow-hidden">
        <div class="flex animate-marquee whitespace-nowrap gap-16 items-center opacity-40">
            @foreach(['LARAVEL', 'LIVEWIRE', 'TAILWIND', 'ALPINE.JS', 'MYSQL', 'REDIS', 'GIT', 'DOCKER', 'AWS', 'VITE'] as $tech)
                <span class="text-2xl font-bold font-mono text-slate-400">{{ $tech }}</span>
            @endforeach
            @foreach(['LARAVEL', 'LIVEWIRE', 'TAILWIND', 'ALPINE.JS', 'MYSQL', 'REDIS', 'GIT', 'DOCKER', 'AWS', 'VITE'] as $tech)
                <span class="text-2xl font-bold font-mono text-slate-400">{{ $tech }}</span>
            @endforeach
        </div>
    </div>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="py-20 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20 max-w-2xl mx-auto">
                <span class="text-blue-600 font-bold tracking-wider text-xs uppercase mb-3 block">Streamlined Workflow</span>
                <h2 class="text-4xl font-extrabold text-slate-900 mb-6">From Assignment to Payment</h2>
                <p class="text-lg text-slate-500">We've removed the bottleneck of negotiations and manual invoicing. Focus on code.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-10 relative">
                <!-- Line -->
                <div class="absolute top-12 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-slate-200 to-transparent hidden md:block z-0"></div>

                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 relative z-10 group hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl flex items-center justify-center font-bold text-2xl mb-6 shadow-sm group-hover:border-blue-500 group-hover:text-blue-600 transition-colors">1</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Claim Task</h3>
                    <p class="text-slate-500 leading-relaxed">Browse the Claim Center for available tickets. Filter by budget or tech stack. Click 'Claim' to lock it.</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 relative z-10 group hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl flex items-center justify-center font-bold text-2xl mb-6 shadow-sm group-hover:border-purple-500 group-hover:text-purple-600 transition-colors">2</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Execute & Ship</h3>
                    <p class="text-slate-500 leading-relaxed">Complete the deliverables. Update progress on the dashboard. Submit PRs and documentation.</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 relative z-10 group hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 bg-white border-2 border-slate-100 text-slate-900 rounded-2xl flex items-center justify-center font-bold text-2xl mb-6 shadow-sm group-hover:border-green-500 group-hover:text-green-600 transition-colors">3</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Receive Payout</h3>
                    <p class="text-slate-500 leading-relaxed">Once approved, the system generates your invoice. Net payment (minus fee) is transferred to your account.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING / RATES -->
    <section id="rates" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/20 blur-[100px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-4xl font-extrabold mb-6">Standard Compensation Rates</h2>
                    <p class="text-slate-400 text-lg">Transparent pricing for standard deliverables. Complex projects may vary.</p>
                </div>
                <!-- Toggle (Visual Only) -->
                <div class="flex bg-slate-800 p-1 rounded-xl border border-slate-700">
                    <button class="px-6 py-2 bg-white text-slate-900 rounded-lg font-bold text-sm shadow-sm">Project Based</button>
                    <button class="px-6 py-2 text-slate-400 hover:text-white rounded-lg font-bold text-sm transition-colors">Hourly</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Rate Card 1 -->
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-3xl p-8 hover:border-blue-500/50 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Bug Fixes / Minor</h3>
                    <p class="text-slate-400 text-sm mb-6 h-10">Single component fixes, styling adjustments, or script optimization.</p>
                    <div class="text-3xl font-mono font-bold text-white mb-1">Rp 150.000<span class="text-sm text-slate-500 font-sans font-normal"> / ticket</span></div>
                    <div class="text-xs text-green-400 font-mono mb-8">Payout: < 24 Hours</div>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex gap-3"><span class="text-blue-500">✓</span> Quick Turnaround</li>
                        <li class="flex gap-3"><span class="text-blue-500">✓</span> Code Review Required</li>
                    </ul>
                </div>

                <!-- Rate Card 2 (Featured) -->
                <div class="bg-gradient-to-b from-blue-600 to-blue-700 rounded-3xl p-8 transform md:-translate-y-4 shadow-2xl shadow-blue-900/50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="uppercase tracking-widest text-xs font-bold text-blue-200 mb-6">Most Common</div>
                    <h3 class="text-2xl font-bold mb-2">Feature Module</h3>
                    <p class="text-blue-100 text-sm mb-6 h-10">CRUD modules, API integration, or new page implementation.</p>
                    <div class="text-3xl font-mono font-bold text-white mb-1">Rp 1.500.000<span class="text-sm text-blue-200 font-sans font-normal"> / module</span></div>
                    <div class="text-xs text-white font-mono mb-8 opacity-80">Payout: Upon Completion</div>
                    <ul class="space-y-3 text-sm text-white font-medium">
                        <li class="flex gap-3"><span>✓</span> Full Stack Implementation</li>
                        <li class="flex gap-3"><span>✓</span> Unit Tests Included</li>
                        <li class="flex gap-3"><span>✓</span> Documentation</li>
                    </ul>
                    <a href="{{ route('login') }}" class="mt-8 block w-full py-3 bg-white text-blue-700 font-bold text-center rounded-xl hover:bg-blue-50 transition-colors">Browse Tasks</a>
                </div>

                <!-- Rate Card 3 -->
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-3xl p-8 hover:border-purple-500/50 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Full Application</h3>
                    <p class="text-slate-400 text-sm mb-6 h-10">End-to-end development for MVPs or internal tools.</p>
                    <div class="text-3xl font-mono font-bold text-white mb-1">Rp 8.000.000<span class="text-sm text-slate-500 font-sans font-normal"> / project</span></div>
                    <div class="text-xs text-purple-400 font-mono mb-8">Payout: Milestone Based</div>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex gap-3"><span class="text-purple-500">✓</span> System Architecture</li>
                        <li class="flex gap-3"><span class="text-purple-500">✓</span> Deployment Setup</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 bg-slate-50">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-center text-slate-900 mb-16">Frequently Asked Questions</h2>

            <div class="space-y-4" x-data="{ active: null }">
                <!-- Item 1 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm cursor-pointer hover:border-blue-300 transition-all" @click="active = (active === 1 ? null : 1)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-900">How do I verify my account?</h4>
                        <span class="text-slate-400 transform transition-transform" :class="active === 1 ? 'rotate-180' : ''">▼</span>
                    </div>
                    <div x-show="active === 1" x-collapse2 class="text-slate-500 mt-4 text-sm leading-relaxed" style="display: none;">
                        Currently, DjokiHub is invite-only. Please contact the administrator to get your credentials. Once logged in, you can complete your profile.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm cursor-pointer hover:border-blue-300 transition-all" @click="active = (active === 2 ? null : 2)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-900">When are payments processed?</h4>
                        <span class="text-slate-400 transform transition-transform" :class="active === 2 ? 'rotate-180' : ''">▼</span>
                    </div>
                    <div x-show="active === 2" x-collapse2 class="text-slate-500 mt-4 text-sm leading-relaxed" style="display: none;">
                        Payments are processed every Friday for deliverables approved before Wednesday. You will receive a notification via email once the transfer is initiated.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm cursor-pointer hover:border-blue-300 transition-all" @click="active = (active === 3 ? null : 3)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-900">What is the admin fee?</h4>
                        <span class="text-slate-400 transform transition-transform" :class="active === 3 ? 'rotate-180' : ''">▼</span>
                    </div>
                    <div x-show="active === 3" x-collapse2 class="text-slate-500 mt-4 text-sm leading-relaxed" style="display: none;">
                        The platform charges a variable admin fee (typically 10-15%) per project to cover server costs and management overhead. The 'Nett Budget' shown to you is what you take home.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <!-- FOOTER -->
    <!-- FOOTER -->
    <footer class="bg-white/80 backdrop-blur-xl border-t border-slate-200 mt-auto">
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
