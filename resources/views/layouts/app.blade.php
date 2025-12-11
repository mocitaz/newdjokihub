<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'DjokiHub') - Project Management System</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 antialiased flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false, logoutModalOpen: false }">
    @auth
        <!-- Top Bar Navigation (Premium Command Strip) -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50 supports-[backdrop-filter]:bg-white/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <!-- Left: Logo & Mobile Trigger -->
                    <div class="flex items-center gap-4">
                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 -ml-2 rounded-xl text-gray-500 hover:bg-gray-100/80 hover:text-gray-900 transition-all active:scale-95">
                                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Brand Identity -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group relative">
                            <div class="relative flex items-center justify-center">
                                <div class="absolute inset-0 bg-blue-500/20 blur-[6px] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <img src="{{ asset('images/logo.png') }}" class="relative h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                                <div style="display: none;" class="text-blue-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                            </div>
                            <span class="font-display font-bold text-lg tracking-tight text-gray-900">
                                DjokiHub<span class="text-blue-600">.</span>
                            </span>
                        </a>
                    </div>

                    <!-- Center: Compact Navigation Pills -->
                    <div class="hidden md:flex items-center gap-1 bg-gray-50/50 p-1 rounded-full border border-gray-100/50 shadow-inner">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-gray-900 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/50' }}">
                            Dashboard
                        </a>

                        <!-- Projects Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" :class="{ 'bg-gray-100/80 text-gray-900': open, 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/50': !open }" class="flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-medium transition-all">
                                Projects
                                <svg class="w-3 h-3 opacity-50 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-64 bg-white rounded-2xl shadow-xl ring-1 ring-black/5 p-1 z-50">
                                <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Workspace</div>
                                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">All Projects</div>
                                </a>
                                <a href="{{ route('claim-center.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium flex justify-between items-center">
                                        Claim Center
                                        @livewire('claim-center-badge')
                                    </div>
                                </a>
                                <div class="my-1 border-t border-gray-100"></div>
                                <a href="{{ route('analytics.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">Analytics</div>
                                </a>
                            </div>
                        </div>

                         <!-- Management Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" :class="{ 'bg-gray-100/80 text-gray-900': open, 'text-gray-500 hover:text-gray-900 hover:bg-gray-100/50': !open }" class="flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-medium transition-all">
                                Management
                                <svg class="w-3 h-3 opacity-50 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-56 bg-white rounded-2xl shadow-xl ring-1 ring-black/5 p-1 z-50">
                                <a href="{{ route('staff.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">Staff Team</div>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('activity-logs.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">Activity Logs</div>
                                </a>
                                <a href="{{ route('admin.assets.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">System Assets</div>
                                </a>
                                @endif
                                <a href="{{ route('wiki.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                    <div class="flex-1 font-medium">Wiki Knowledge</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right: User Menu -->
                    <div class="flex items-center gap-4">
                        
                        <!-- Notifications -->
                        @livewire('notifications-dropdown')

                        <!-- Search Trigger (Mobile) -->
                        <div class="hidden sm:block">
                            @livewire('global-search')
                        </div>



                        <!-- Profile Dropdown (Redesigned) -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="group flex items-center gap-2 pl-2 pr-1.5 py-1.5 rounded-full hover:bg-gray-100/80 transition-all border border-transparent hover:border-gray-200">
                                <div class="relative">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm group-hover:ring-gray-200 transition-all" alt="{{ auth()->user()->name }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-800 to-black text-white flex items-center justify-center text-xs font-bold ring-2 ring-white shadow-sm group-hover:ring-gray-200 transition-all">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <span class="hidden md:block text-xs font-bold text-gray-700 group-hover:text-gray-900 truncate max-w-[100px]">
                                    {{ implode(' ', array_slice(explode(' ', auth()->user()->name), 0, 2)) }}
                                </span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- User Card Dropdown -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-2 scale-95" class="absolute right-0 mt-3 w-72 bg-white rounded-3xl shadow-2xl ring-1 ring-black/5 overflow-hidden z-50">
                                <!-- Card Header -->
                                <div class="px-6 py-5 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                                    <div class="flex items-center gap-4">
                                        @if(auth()->user()->profile_photo_url)
                                            <img src="{{ auth()->user()->profile_photo_url }}" class="w-12 h-12 rounded-full object-cover shadow-lg border-2 border-white" alt="{{ auth()->user()->name }}">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center text-lg font-bold shadow-lg border-2 border-white">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="overflow-hidden">
                                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</h4>
                                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                            <span class="inline-flex items-center mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ auth()->user()->isAdmin() ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600' }}">
                                                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Staff Member' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="p-2 space-y-1">
                                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        My Profile
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors group">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Settings
                                    </a>
                                </div>

                                <!-- Footer -->
                                <div class="p-2 border-t border-gray-100 bg-gray-50/50">
                                    <button @click="logoutModalOpen = true" type="button" class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-bold text-red-600 rounded-xl hover:bg-red-50 transition-colors group">
                                        Sign Out
                                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
             x-transition:enter="transition ease-out duration-150" 
             x-transition:enter-start="opacity-0 -translate-y-1" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-100" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden fixed top-16 left-0 right-0 bg-white border-b border-gray-100 shadow-lg z-40" style="display: none;">
            <div class="px-4 py-3 space-y-1">
                <!-- Mobile Search -->
                <div class="mb-4 pb-4 border-b border-gray-100">
                    @livewire('global-search')
                </div>

                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Dashboard
                </a>
                <a href="{{ route('projects.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    All Projects
                </a>
                <a href="{{ route('claim-center.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Claim Center
                </a>
                <a href="{{ route('analytics.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Analytics
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('staff.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Staff
                </a>
                <a href="{{ route('activity-logs.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Activity Logs
                </a>
                <a href="{{ route('admin.assets.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    System Assets
                </a>
                @endif
                <a href="{{ route('wiki.index') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                    Wiki
                </a>

                <!-- Mobile User Menu -->
                <div class="border-t border-gray-100 my-2 pt-2">
                    <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[10px] text-gray-600 font-bold overflow-hidden">
                            @if(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 1) }}
                            @endif
                        </div>
                        {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                        My Profile
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors rounded-lg">
                        Settings
                    </a>
                    <button @click="logoutModalOpen = true" class="w-full text-left block px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors rounded-lg">
                        Sign Out
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="pt-16 flex-grow">
            @yield('content')

        </main>

        <!-- APP FOOTER -->
        <footer class="mt-auto py-8 px-6 bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-gray-900 text-sm">DjokiHub v2.0</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs text-gray-500">by Djoki Coding</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Subsidiary of</span>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/teknalogi.png') }}" alt="Teknalogi" class="h-5 opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all">
                        <span class="text-[10px] font-bold text-gray-500 hover:text-gray-700 transition-colors">PT. Teknalogi Transformasi Digital</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Hidden Logout Form -->
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>

        <!-- Logout Confirmation Modal -->
        <div x-show="logoutModalOpen" class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <!-- Backdrop -->
            <div x-show="logoutModalOpen" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal Panel -->
                    <div x-show="logoutModalOpen" 
                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         @click.outside="logoutModalOpen = false"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md ring-1 ring-black/5">
                        
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Ready to leave?</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            You are about to sign out of your session. Do you want to continue?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                            <button type="button" onclick="document.getElementById('logout-form').submit()" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                                Yes, Sign Out
                            </button>
                            <button type="button" @click="logoutModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @yield('content')
    @endauth

    @livewireScripts
    @stack('scripts')
</body>
</html>

