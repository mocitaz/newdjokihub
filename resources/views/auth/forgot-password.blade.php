<x-layouts.split>
    <x-slot:left>
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-white text-black flex items-center justify-center font-bold text-lg">D</div>
            <span class="font-bold text-xl tracking-tight font-display text-white">DjokiHub<span class="text-zinc-500">.</span></span>
        </div>

        <!-- Center Visual -->
        <div class="flex-1 flex items-center justify-center animate-fade-in-up delay-100">
             <div class="text-center group">
                 <div class="inline-flex items-center justify-center w-24 h-24 rounded-full border border-zinc-800 bg-zinc-900/50 mb-8 backdrop-blur-sm shadow-[0_0_30px_rgba(255,255,255,0.05)] group-hover:scale-110 transition-transform duration-700 ease-in-out relative">
                     <div class="absolute inset-0 rounded-full border border-white/5 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
                     <svg class="w-10 h-10 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                 </div>
                 <h2 class="text-4xl font-bold font-display tracking-tight text-white mb-4">Account Recovery</h2>
                 <p class="text-zinc-500 text-sm max-w-xs mx-auto leading-relaxed">
                     Securely reset your credentials and get back to work.
                 </p>
             </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center text-xs text-zinc-600 font-mono">
            <span>SYSTEM v2.0</span>
            <span>&copy; {{ date('Y') }}</span>
        </div>
    </x-slot>

    <!-- Right Side: Form -->
    <div class="animate-fade-in-up">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-black font-display tracking-tight">Forgot Password?</h1>
            <p class="text-xs text-zinc-400 mt-1 font-medium leading-relaxed">
                No problem. Enter your email address to receive a password reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1">
                <label for="email" class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </div>
                    <input id="email" class="block w-full pl-10 pr-3 py-2.5 border-zinc-200 rounded-lg text-sm text-zinc-900 placeholder-zinc-400 focus:border-black focus:ring-black transition-colors" 
                           type="email" name="email" :value="old('email')" required autofocus placeholder="name@company.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 bg-black text-white font-bold text-sm rounded-lg hover:bg-zinc-800 transition-all transform active:scale-95 shadow-lg shadow-zinc-200">
                    EMAIL PASSWORD RESET LINK
                </button>
            </div>
            
            <div class="text-center pt-4">
                <a href="{{ route('login') }}" class="text-xs font-bold text-zinc-400 hover:text-black transition-colors inline-flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</x-layouts.split>
