@extends('layouts.app')

@section('title', 'Digital Asset Registry')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'universities', search: '', showUnivModal: false, showBankModal: false }">
    
    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-1">System Configuration</p>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Digital Asset Registry</h1>
            <p class="text-gray-500 mt-1">Manage institutional logos and banking identifiers.</p>
        </div>
        <div class="flex items-center gap-3 bg-gray-100/50 p-1 rounded-xl">
            <button @click="activeTab = 'universities'" 
                    :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'universities', 'text-gray-500 hover:text-gray-700': activeTab !== 'universities' }"
                    class="px-4 py-2 text-sm font-bold rounded-lg transition-all">
                Universities
            </button>
            <button @click="activeTab = 'banks'" 
                    :class="{ 'bg-white shadow-sm text-gray-900': activeTab === 'banks', 'text-gray-500 hover:text-gray-700': activeTab !== 'banks' }"
                    class="px-4 py-2 text-sm font-bold rounded-lg transition-all">
                Banks
            </button>
        </div>
    </div>

    <!-- Search & Actions -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative w-full md:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" x-model="search" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 placeholder-gray-400 transition-all" placeholder="Search assets...">
        </div>
        <div>
            <button x-show="activeTab === 'universities'" @click="showUnivModal = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add University
            </button>
            <button x-show="activeTab === 'banks'" @click="showBankModal = true" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm" style="display: none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Bank
            </button>
        </div>
    </div>

    <!-- UNIVERSITIES GRID -->
    <div x-show="activeTab === 'universities'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        @foreach($universities as $university)
        <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-lg hover:border-blue-200 transition-all relative overflow-hidden university-item"
             data-name="{{ strtolower($university->name) }}"
             data-acronym="{{ strtolower($university->acronym ?? '') }}"
             data-city="{{ strtolower($university->city ?? '') }}"
             x-show="search === '' || '{{ strtolower($university->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($university->acronym ?? '') }}'.includes(search.toLowerCase())">
            
            <div class="flex items-start gap-4">
                <!-- Logo Slot -->
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center relative overflow-hidden group-hover:bg-white transition-colors">
                    @if($university->logo_url)
                        @php
                            $logoUrl = str_starts_with($university->logo_url, 'logos/') 
                                ? Storage::url($university->logo_url) 
                                : $university->logo_url;
                        @endphp
                        <img src="{{ $logoUrl }}" class="w-10 h-10 object-contain transition-transform group-hover:scale-110" onerror="this.parentElement.innerHTML='<svg class=\'w-10 h-10 text-gray-300\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'></path></svg>'">
                    @else
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    @endif

                    <!-- Upload Overlay -->
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <label class="cursor-pointer text-white hover:text-blue-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <form class="upload-form hidden" data-type="university" data-id="{{ $university->id }}">
                                @csrf
                                <input type="file" name="logo" accept="image/*" class="logo-input" onchange="this.form.dispatchEvent(new Event('submit'))">
                            </form>
                        </label>
                        @if($university->logo_url)
                        <button type="button" class="delete-logo ml-2 text-white hover:text-red-300 transition-colors" data-type="university" data-id="{{ $university->id }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $university->type == 'negeri' ? 'bg-blue-50 text-blue-600' : 'bg-orange-50 text-orange-600' }}">
                            {{ ucfirst($university->type) }}
                        </span>
                        @if($university->acronym)
                        <span class="text-xs font-bold text-gray-400">{{ $university->acronym }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 leading-tight truncate" title="{{ $university->name }}">{{ $university->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $university->city ?? 'Unknown City' }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- BANKS GRID -->
    <div x-show="activeTab === 'banks'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        @foreach($banks as $bank)
        <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-lg hover:border-green-200 transition-all relative overflow-hidden bank-item"
             data-name="{{ strtolower($bank->name) }}"
             data-code="{{ strtolower($bank->code ?? '') }}"
             x-show="search === '' || '{{ strtolower($bank->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($bank->code ?? '') }}'.includes(search.toLowerCase())">
            
            <div class="flex items-start gap-4">
                <!-- Logo Slot -->
                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center relative overflow-hidden group-hover:bg-white transition-colors">
                    @if($bank->logo_url)
                        @php
                            $logoUrl = str_starts_with($bank->logo_url, 'logos/') 
                                ? Storage::url($bank->logo_url) 
                                : $bank->logo_url;
                        @endphp
                        <img src="{{ $logoUrl }}" class="w-10 h-10 object-contain transition-transform group-hover:scale-110" onerror="this.parentElement.innerHTML='<svg class=\'w-10 h-10 text-gray-300\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z\'></path></svg>'">
                    @else
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    @endif

                    <!-- Upload Overlay -->
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <label class="cursor-pointer text-white hover:text-green-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <form class="upload-form hidden" data-type="bank" data-id="{{ $bank->id }}">
                                @csrf
                                <input type="file" name="logo" accept="image/*" class="logo-input" onchange="this.form.dispatchEvent(new Event('submit'))">
                            </form>
                        </label>
                        @if($bank->logo_url)
                        <button type="button" class="delete-logo ml-2 text-white hover:text-red-300 transition-colors" data-type="bank" data-id="{{ $bank->id }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-green-50 text-green-600">
                           Code: {{ $bank->code ?? 'N/A' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 leading-tight truncate">{{ $bank->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        SWIFT: {{ $bank->swift_code ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Grid Ends -->

    <!-- Add University Modal -->
    <div x-show="showUnivModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="min-h-screen px-4 text-center">
            
            <!-- Backdrop -->
            <div x-show="showUnivModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 aria-hidden="true"
                 @click="showUnivModal = false"></div>

            <!-- Spacer -->
            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div x-show="showUnivModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                
                <form id="add-university-form">
                    @csrf
                    <div class="pb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-4" id="modal-title">Add New University</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Acronym</label>
                                    <input type="text" name="acronym" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                </div>
                                 <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Type <span class="text-red-500">*</span></label>
                                    <select name="type" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                        <option value="negeri">Negeri (Public)</option>
                                        <option value="swasta">Swasta (Private)</option>
                                    </select>
                                </div>
                            </div>

                             <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">City</label>
                                    <input type="text" name="city" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                </div>
                                 <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Province</label>
                                    <input type="text" name="province" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Website</label>
                                <input type="url" name="website" placeholder="https://" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <button type="button" @click="showUnivModal = false" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white text-sm font-bold rounded-lg hover:bg-gray-800 shadow-lg">Save Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bank Modal -->
    <div x-show="showBankModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="min-h-screen px-4 text-center">
            
            <!-- Backdrop -->
            <div x-show="showBankModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                 aria-hidden="true"
                 @click="showBankModal = false"></div>

            <!-- Spacer -->
            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div x-show="showBankModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative z-10">
                
                <form id="add-bank-form">
                    @csrf
                    <div class="pb-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-4" id="modal-title">Add New Bank</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bank Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bank Code</label>
                                    <input type="text" name="code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                </div>
                                 <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">SWIFT Code</label>
                                    <input type="text" name="swift_code" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium">
                                </div>
                            </div>

                             <div>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" checked class="w-4 h-4 rounded border-gray-300 text-black focus:ring-black">
                                    <span class="text-sm font-medium text-gray-700">Active Status</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                        <button type="button" @click="showBankModal = false" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white text-sm font-bold rounded-lg hover:bg-gray-800 shadow-lg">Save Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<script>
// Global Notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-24 right-4 z-[99] px-6 py-4 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border ${
        type === 'success' ? 'bg-white border-green-100 text-green-700' : 'bg-white border-red-100 text-red-700'
    } font-bold text-sm transform transition-all duration-300 flex items-center gap-3`;
    
    const icon = type === 'success' 
        ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        
    notification.innerHTML = icon + message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Form Handlers
document.addEventListener('DOMContentLoaded', function() {
    
    // Add University
    document.getElementById('add-university-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        button.disabled = true; button.textContent = 'Saving...';
        
        try {
            const response = await fetch('/admin/assets/university', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            });
            const data = await response.json();
            if (data.success) {
                showNotification(data.message, 'success');
                // Use Alpine state via global dispatch if strictly needed, or just let reload handle it
                // Since reload happens below, we don't strictly need to toggle the Alpine variable if page reloads
                setTimeout(() => location.reload(), 800);
            } else {
                throw new Error(data.message || 'Validation failed');
            }
        } catch (error) {
            showNotification(error.message, 'error');
            button.disabled = false; button.textContent = originalText;
        }
    });

    // Add Bank
    document.getElementById('add-bank-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        button.disabled = true; button.textContent = 'Saving...';
        
        try {
            const response = await fetch('/admin/assets/bank', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            });
            const data = await response.json();
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                throw new Error(data.message || 'Validation failed');
            }
        } catch (error) {
            showNotification(error.message, 'error');
            button.disabled = false; button.textContent = originalText;
        }
    });

    // Handle File Uploads (Triggered on change)
    document.querySelectorAll('.upload-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent default submission
            const container = this.closest('.group');
            container.classList.add('opacity-50', 'pointer-events-none');
            
            try {
                const type = this.dataset.type;
                const id = this.dataset.id;
                const url = type === 'university' ? `/admin/assets/university/${id}/logo` : `/admin/assets/bank/${id}/logo`;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: new FormData(this)
                });
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Logo uploaded successfully', 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                showNotification(error.message, 'error');
                container.classList.remove('opacity-50', 'pointer-events-none');
            }
        });
    });

    // Handle Deletes
    document.querySelectorAll('.delete-logo').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault(); e.stopPropagation();
            if(!confirm('Remove this asset logo?')) return;
            
            try {
                const type = this.dataset.type;
                const id = this.dataset.id;
                const url = type === 'university' ? `/admin/assets/university/${id}/logo` : `/admin/assets/bank/${id}/logo`;
                
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    showNotification('Logo removed', 'success');
                    setTimeout(() => location.reload(), 500);
                }
            } catch (error) {
                showNotification('Failed to remove logo', 'error');
            }
        });
    });

});
</script>
@endsection
