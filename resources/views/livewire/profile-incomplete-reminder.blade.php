<div x-data="{ show: @entangle('showModal') }"
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 border border-gray-200 relative overflow-hidden" @click.stop>
        
        <div class="text-center">
            <!-- Minimalist Icon -->
            <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            
            <h2 class="text-xl font-bold text-gray-900 mb-1 tracking-tight">Complete Your Profile</h2>
            <p class="text-xs text-gray-500 mb-5">
                Required for project claims & payouts.
            </p>

            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left border border-gray-100">
                <ul class="space-y-2">
                    @foreach($missingFields as $field)
                    <li class="flex items-center gap-2 text-xs font-semibold text-gray-700">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                        {{ $field }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex flex-col gap-2.5">
                <button wire:click="updateProfile" class="w-full flex justify-center items-center py-2.5 px-4 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-lg transition-all shadow-md hover:shadow-lg">
                    Update Profile
                </button>
                <button wire:click="remindLater" class="w-full py-2 text-gray-400 hover:text-gray-600 font-medium text-xs transition-colors">
                    Remind me later
                </button>
            </div>
        </div>
    </div>
</div>
