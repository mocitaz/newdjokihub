<x-layouts.split>
    <x-slot:left>
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 w-fit">
            <img src="{{ asset('images/logo.png') }}" alt="DjokiHub" class="w-10 h-10 rounded-xl shadow-sm object-contain bg-white">
            <span class="font-bold text-2xl tracking-tight font-display text-slate-900">DjokiHub<span class="text-blue-600">.</span></span>
        </a>

        <!-- Center Visual -->
        <div class="flex-1 flex items-center justify-center animate-fade-in-up delay-100">
             <div class="relative w-full max-w-sm">
                 <!-- Glass Card Effect -->
                 <div class="absolute inset-0 bg-white/40 backdrop-blur-xl rounded-3xl transform rotate-6 border border-white/50 shadow-2xl skew-y-3"></div>
                 <div class="relative bg-white/60 backdrop-blur-xl rounded-3xl p-8 border border-white/60 shadow-xl">
                     <div class="flex items-center gap-4 mb-6">
                         <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                         </div>
                         <div>
                             <h3 class="font-bold text-slate-900 text-lg">Secure Portal</h3>
                             <p class="text-xs text-slate-500">Enterprise Grade Encryption</p>
                         </div>
                     </div>
                     <div class="space-y-4">
                         <div class="h-2 w-3/4 bg-slate-200/50 rounded-full"></div>
                         <div class="h-2 w-1/2 bg-slate-200/50 rounded-full"></div>
                         <div class="h-2 w-full bg-slate-200/50 rounded-full"></div>
                     </div>
                     <div class="mt-8 pt-6 border-t border-slate-200/50 flex justify-between items-center">
                         <div class="flex -space-x-2">
                             <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white"></div>
                             <div class="w-8 h-8 rounded-full bg-slate-200 border-2 border-white"></div>
                             <div class="w-8 h-8 rounded-full bg-slate-300 border-2 border-white"></div>
                         </div>
                         <div class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full">
                             v2.0 Active
                         </div>
                     </div>
                 </div>
             </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center text-xs text-slate-500 font-mono font-medium">
            <span>djokihub.internal</span>
            <span>&copy; {{ date('Y') }} Inc.</span>
        </div>
    </x-slot>

    <!-- Right Side: Form -->
    <div x-data="{ modalOpen: false }" class="animate-fade-in-up">
        
        <!-- Login Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-black font-display tracking-tight">Login</h1>
            <p class="text-xs text-zinc-400 mt-1 font-medium">Please enter your credentials.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1">
                <label for="email" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </div>
                    <input id="email" class="block w-full pl-10 pr-3 py-2.5 border-zinc-200 rounded-lg text-sm text-zinc-900 placeholder-zinc-400 focus:border-black focus:ring-black transition-colors" 
                           type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                     <label for="password" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Password</label>
                     @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-zinc-400 hover:text-black transition-colors">Forgot?</a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <input id="password" class="block w-full pl-10 pr-3 py-2.5 border-zinc-200 rounded-lg text-sm text-zinc-900 placeholder-zinc-400 focus:border-black focus:ring-black transition-colors" 
                           type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="block pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded border-zinc-300 text-black shadow-sm focus:ring-black transition-colors" name="remember">
                    <span class="ms-2 text-xs font-medium text-zinc-500 group-hover:text-black transition-colors">Remember me for 30 days</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 bg-black text-white font-bold text-sm rounded-lg hover:bg-zinc-800 transition-all transform active:scale-95 shadow-lg shadow-zinc-200">
                    Sign In
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-xs text-zinc-400">
                No account? 
                <button @click="modalOpen = true" class="font-bold text-black hover:underline">
                    Contact Admin
                </button>
            </p>
        </div>

        <!-- Minimalist Modal -->
        <div x-show="modalOpen" style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center px-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="absolute inset-0 bg-white/80 backdrop-blur-sm" @click="modalOpen = false"></div>

            <div class="bg-white rounded-2xl p-8 max-w-sm w-full relative z-10 border border-zinc-100 shadow-2xl text-center"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                
                <h3 class="text-lg font-bold text-black mb-2">Restricted Access</h3>
                <p class="text-xs text-zinc-500 mb-6 leading-relaxed">
                    Account creation is invite-only. Please contact the administrator to request credentials.
                </p>

                <div class="flex flex-col gap-2">
                    <a href="mailto:admin@djokicoding.com" class="w-full py-2 bg-black text-white font-bold text-xs rounded-lg hover:bg-zinc-800 transition-colors">
                        Email Admin
                    </a>
                    <button @click="modalOpen = false" class="w-full py-2 bg-white border border-zinc-200 text-zinc-600 font-bold text-xs rounded-lg hover:bg-zinc-50 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-layouts.split>
