@extends('layouts.app')

@section('title', 'Onboard Talent')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Onboard New Talent</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Add a new staff member to the ecosystem.</p>
        </div>
        <a href="{{ route('staff.index') }}" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- CARD 1: IDENTITY -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-blue-500 to-indigo-600 transform origin-bottom scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>
            
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-50">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Personal Identity</h3>
                    <p class="text-xs text-gray-500 font-medium">Basic personal information for the profile.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Photo Upload -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Photo</label>
                    <div class="relative group/photo cursor-pointer w-32 h-32 mx-auto md:mx-0">
                        <div class="w-32 h-32 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 group-hover/photo:border-blue-400 group-hover/photo:text-blue-500 transition-all overflow-hidden">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-[10px] font-bold uppercase">Upload</span>
                        </div>
                        <input type="file" name="profile_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                    </div>
                </div>

                <!-- Fields -->
                <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none font-medium placeholder-gray-400" placeholder="e.g. John Doe">
                        @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none font-medium placeholder-gray-400" placeholder="john@example.com">
                        @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">WhatsApp / Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none font-medium placeholder-gray-400" placeholder="0812...">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Age</label>
                            <input type="number" name="umur" value="{{ old('umur') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none font-medium placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">City</label>
                            <input type="text" name="domisili" value="{{ old('domisili') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none font-medium placeholder-gray-400">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: PROFESSIONAL -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-all duration-300">
             <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-purple-500 to-pink-600 transform origin-bottom scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>

            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-50">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Background & Socials</h3>
                    <p class="text-xs text-gray-500 font-medium">Academic history and professional links.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">University <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="university_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none font-medium cursor-pointer appearance-none">
                                <option value="">Select University...</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                        {{ $university->name }} {{ $university->acronym ? "({$university->acronym})" : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Major / Program Study</label>
                        <div class="relative">
                            <select name="program_study" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none font-medium cursor-pointer appearance-none">
                                <option value="">Select Major...</option>
                                @foreach($majors as $major)
                                    <option value="{{ $major }}" {{ old('program_study') == $major ? 'selected' : '' }}>
                                        {{ $major }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">GitHub</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path></svg>
                        </span>
                        <input type="url" name="github" value="{{ old('github') }}" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none font-medium placeholder-gray-400" placeholder="https://github.com/...">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">LinkedIn</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path></svg>
                        </span>
                        <input type="url" name="linkedin" value="{{ old('linkedin') }}" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none font-medium placeholder-gray-400" placeholder="https://linkedin.com/...">
                    </div>
                </div>
            </div>
        </div>

        <!-- GRID 3: Financial & Security -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Financial -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-green-500 to-emerald-600 transform origin-bottom scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>

                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-50">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Financial</h3>
                        <p class="text-[10px] text-gray-500 font-medium">Bank details for payments.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Bank</label>
                        <select name="bank_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all outline-none font-medium text-sm cursor-pointer">
                            <option value="">Select Bank...</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                         <label class="block text-xs font-bold text-gray-700 mb-1.5">Account Number</label>
                         <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all outline-none font-medium text-sm">
                    </div>
                    <div>
                         <label class="block text-xs font-bold text-gray-700 mb-1.5">Account Name</label>
                         <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all outline-none font-medium text-sm">
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-red-500 to-rose-600 transform origin-bottom scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>

                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-50">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Security</h3>
                        <p class="text-[10px] text-gray-500 font-medium">Account credentials.</p>
                    </div>
                </div>

                <div class="space-y-4">
                     <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none font-medium text-sm">
                        @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                     </div>
                     <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none font-medium text-sm">
                     </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-4">
             <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 bg-black text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
                Create Ecosystem Profile
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </button>
        </div>

    </form>
</div>
@endsection
