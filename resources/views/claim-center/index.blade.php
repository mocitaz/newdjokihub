@extends('layouts.app')

@section('title', 'Claim Center')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Compact Header -->
    <!-- Simple Header -->
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-bold uppercase tracking-wider mb-2 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                Opportunities
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Claim Center</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Fast Claim - Grab the best projects before they're gone.</p>
        </div>
        <div>
            <!-- Header Actions (if any) could go here -->
        </div>
    </div>

    @livewire('claim-center-list')
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Auto-refresh every 5 seconds
        setInterval(() => {
            if (window.Livewire) {
                Livewire.dispatch('refresh-projects');
            }
        }, 5000);

        // Listen for claim success
        Livewire.on('claim-success', (event) => {
            showNotification(event.message || 'Project claimed successfully!', 'success');
        });

        // Listen for claim error
        Livewire.on('claim-error', (event) => {
            showNotification(event.message || 'Failed to claim project!', 'error');
        });
    });

    function showNotification(message, type) {
        // Remove existing notifications to prevent stacking
        const existing = document.querySelectorAll('.custom-toast');
        existing.forEach(el => el.remove());

        const notification = document.createElement('div');
        notification.className = 'custom-toast fixed top-24 right-6 z-50 transform transition-all duration-500 ease-out translate-x-full opacity-0';
        
        // Premium Design
        const isSuccess = type === 'success';
        const bgColor = isSuccess ? 'bg-white' : 'bg-white';
        const borderColor = isSuccess ? 'border-emerald-100' : 'border-red-100';
        const iconColor = isSuccess ? 'text-emerald-500 bg-emerald-50' : 'text-red-500 bg-red-50';
        const title = isSuccess ? 'Success!' : 'Error';
        const icon = isSuccess 
            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

        notification.innerHTML = `
            <div class="flex items-start gap-4 p-4 pr-12 min-w-[320px] max-w-md ${bgColor} rounded-2xl border ${borderColor} shadow-[0_8px_30px_rgb(0,0,0,0.08)] backdrop-blur-md">
                <div class="flex-shrink-0 w-10 h-10 rounded-full ${iconColor} flex items-center justify-center">
                    ${icon}
                </div>
                <div class="flex-1 pt-0.5">
                    <h4 class="text-sm font-bold text-gray-900 leading-none mb-1">${title}</h4>
                    <p class="text-sm font-medium text-gray-600 leading-relaxed">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                ${isSuccess ? '<div class="absolute bottom-0 left-0 h-1 bg-emerald-500 rounded-bl-2xl animation-progress"></div>' : ''}
            </div>
            <style>
                .animation-progress {
                    width: 100%;
                    animation: progress 4s linear forwards;
                }
                @keyframes progress {
                    to { width: 0%; }
                }
            </style>
        `;

        document.body.appendChild(notification);

        // Animate In with spring feel
        requestAnimationFrame(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        });

        // Auto dismiss
        const timeout = setTimeout(() => {
            dismissNotification(notification);
        }, 4000); // 4 seconds
    }

    function dismissNotification(element) {
        element.style.transform = 'translateX(120%)';
        element.style.opacity = '0';
        setTimeout(() => element.remove(), 500);
    }
</script>
@endpush

