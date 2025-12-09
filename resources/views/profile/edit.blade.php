@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-8" x-data="{ showDeleteModal: false }">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <nav class="flex mb-1" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('profile.show') }}" class="text-xs font-medium text-gray-500 hover:text-gray-900 transition-colors">My Profile</a></li>
                        <li><span class="text-gray-300">/</span></li>
                        <li class="text-xs font-bold text-gray-900">Edit</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Profile</h1>
            </div>
            <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                Cancel
            </a>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Error Feedback -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-600 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm">
                    <span class="font-bold">Please fix the following errors:</span>
                    <ul class="mt-1 list-disc list-inside opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Main Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden divide-y divide-gray-100">
                
                <!-- Section: Avatar & Identity -->
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-6 md:gap-10">
                        <div class="w-full md:w-1/3">
                            <h3 class="text-sm font-bold text-gray-900">Public Profile</h3>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">This information is visible to other team members.</p>
                        </div>
                        <div class="w-full md:w-2/3 space-y-5">
                            <!-- Avatar Upload -->
                            <div class="flex items-center gap-5" x-data="{ photoPreview: '{{ $user->profile_photo ? Storage::url($user->profile_photo) : null }}' }">
                                <div class="relative w-16 h-16 flex-shrink-0 group">
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full rounded-full object-cover border border-gray-200 shadow-sm">
                                    </template>
                                    <template x-if="!photoPreview">
                                        <div class="w-full h-full rounded-full bg-gray-100 flex items-center justify-center text-xl font-bold text-gray-400 border border-gray-200">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </template>
                                    <div class="absolute inset-0 rounded-full border border-black/5"></div>
                                </div>
                                <div>
                                    <label class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-xs font-bold text-gray-700 hover:bg-gray-50 cursor-pointer transition-colors">
                                        Change Photo
                                        <input type="file" name="profile_photo" class="hidden"
                                            @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file)"
                                        />
                                    </label>
                                    <p class="mt-1.5 text-[10px] text-gray-400">JPG, GIF or PNG. Max 1MB.</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors placeholder-gray-400">
                                </div>
                                 <div class="opacity-60 cursor-not-allowed">
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Email Address</label>
                                    <input type="email" value="{{ $user->email }}" class="w-full rounded-lg border-gray-200 text-sm px-3.5 py-2.5 bg-gray-100 text-gray-500" readonly disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Personal Details -->
                <div class="p-6 md:p-8">
                     <div class="flex flex-col md:flex-row gap-6 md:gap-10">
                        <div class="w-full md:w-1/3">
                            <h3 class="text-sm font-bold text-gray-900">Personal Details</h3>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Contact info and education.</p>
                        </div>
                        <div class="w-full md:w-2/3 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="0812...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Location (City)</label>
                                    <input type="text" name="domisili" value="{{ old('domisili', $user->domisili) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="e.g. Jakarta">
                                </div>
                            </div>

                             <!-- Education Group -->
                            <div class="pt-2">
                                <label class="block text-xs font-bold text-gray-700 mb-2">Education Background</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <select name="university_id" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3 py-2.5 bg-gray-50 focus:bg-white transition-colors">
                                            <option value="">Select University</option>
                                            @foreach($universities as $university)
                                                <option value="{{ $university->id }}" {{ old('university_id', $user->university_id) == $university->id ? 'selected' : '' }}>
                                                    {{ $university->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <select name="program_study" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3 py-2.5 bg-gray-50 focus:bg-white transition-colors">
                                            <option value="">Select Major</option>
                                            @foreach($majors as $major)
                                                <option value="{{ $major }}" {{ old('program_study', $user->program_study) == $major ? 'selected' : '' }}>
                                                    {{ $major }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                             <!-- Links -->
                            <div class="pt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">GitHub URL</label>
                                    <input type="url" name="github" value="{{ old('github', $user->github) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="https://github.com/...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">LinkedIn URL</label>
                                    <input type="url" name="linkedin" value="{{ old('linkedin', $user->linkedin) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="https://linkedin.com/in/...">
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                
                @if($user->isStaff())
                <!-- Section: Financial -->
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-6 md:gap-10">
                        <div class="w-full md:w-1/3">
                            <h3 class="text-sm font-bold text-gray-900">Financial Details</h3>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Bank account for project payouts.</p>
                        </div>
                        <div class="w-full md:w-2/3 bg-gray-50 rounded-xl p-5 border border-gray-100 space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Bank Name</label>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-white" placeholder="e.g. BCA, Mandiri">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Account Number</label>
                                    <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $user->bank_account_number) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Account Name</label>
                                    <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $user->bank_account_name) }}" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Section: Security -->
                <div class="p-6 md:p-8">
                     <div class="flex flex-col md:flex-row gap-6 md:gap-10">
                        <div class="w-full md:w-1/3">
                            <h3 class="text-sm font-bold text-gray-900">Security</h3>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Change your password.</p>
                        </div>
                        <div class="w-full md:w-2/3">
                             <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">New Password</label>
                                    <input type="password" name="password" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="••••••••" autocomplete="new-password">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-200 focus:border-black focus:ring-black text-sm px-3.5 py-2.5 bg-gray-50 focus:bg-white transition-colors" placeholder="••••••••" autocomplete="new-password">
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2">Leave blank if you don't want to change your password.</p>
                        </div>
                     </div>
                </div>

                <!-- Footer Action -->
                <div class="px-8 py-5 bg-gray-50 flex justify-end items-center border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 bg-black hover:bg-gray-800 text-white font-bold rounded-lg shadow-sm transition-all text-sm focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        Save Changes
                    </button>
                </div>

            </div>
        </form>

        <!-- DANGER ZONE: Delete Account -->
        <div class="mt-10">
             <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
                 <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-red-600">Delete Account</h3>
                            <p class="text-xs text-gray-500 mt-1 max-w-sm">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                        <button @click="showDeleteModal = true" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Confirm Delete Modal (Alpine.js) -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 border border-gray-100" @click.away="showDeleteModal = false">
            <div class="flex items-center gap-3 text-red-600 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-lg font-bold">Delete Account</h3>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently removed.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Please enter your password to confirm</label>
                    <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm px-3 py-2" placeholder="Password" required>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" @click="showDeleteModal = false" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold shadow-lg shadow-red-500/30">
                        Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
