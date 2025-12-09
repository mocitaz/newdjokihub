@extends('layouts.app')

@section('title', 'New Story')

@section('content')
<div class="min-h-screen bg-[#f8fafc] pb-24" x-data="{ 
    title: '{{ old('title') }}',
    showMeta: false,
    imagePreview: null,
    handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => { this.imagePreview = e.target.result; };
            reader.readAsDataURL(file);
        }
    }
}">
    <form method="POST" action="{{ route('wiki.store') }}" enctype="multipart/form-data" class="h-full relative">
        @csrf
        
        <!-- Navbar Spacer -->
        <div class="h-8"></div>

        <!-- Main Canvas -->
        <div class="max-w-4xl mx-auto px-6">
            
            <!-- Breadcrumb / Back -->
            <div class="flex items-center gap-2 mb-6">
                <a href="{{ route('wiki.index') }}" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-black hover:border-black transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                </a>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Back to Wiki</span>
            </div>

            <!-- Paper Container -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/40 border border-gray-100 p-12 relative overflow-hidden">
                
                <!-- Top Decor -->
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 opacity-80"></div>

                <!-- Cover Image (Optional) -->
                <div class="mb-10 group relative" :class="imagePreview ? 'h-72' : 'h-20'">
                    <div class="w-full h-full rounded-2xl overflow-hidden transition-all duration-300 relative bg-gray-50 border-2 border-dashed border-gray-100 group-hover:border-gray-300">
                        <!-- Preview -->
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                        </template>
                        
                        <!-- Upload Prompt -->
                        <div class="absolute inset-0 flex items-center justify-center cursor-pointer transition-opacity" :class="imagePreview ? 'opacity-0 group-hover:opacity-100 bg-black/20 backdrop-blur-sm' : 'opacity-100'">
                            <div class="text-center">
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-sm border border-gray-200 text-xs font-bold text-gray-600 hover:scale-105 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span x-text="imagePreview ? 'Change Cover' : 'Add Cover Image'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="cover_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="handleFileUpload($event)">
                </div>

                <!-- Title -->
                <div class="relative mb-8">
                    <input type="text" name="title" x-model="title"
                        class="w-full text-5xl md:text-6xl font-bold text-gray-900 placeholder-gray-200 border-none outline-none focus:ring-0 p-0 bg-transparent font-display tracking-tight leading-tight"
                        placeholder="Title..." autofocus required>
                    @error('title') <p class="text-red-500 text-sm mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Metadata Row -->
                <div class="flex flex-wrap items-center gap-4 mb-12 p-3 bg-gray-50/50 rounded-xl border border-gray-100 w-fit">
                    <!-- User Avatar -->
                    <div class="flex items-center gap-2 pr-4 border-r border-gray-200">
                        <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="text-xs font-bold text-gray-900">{{ auth()->user()->name }}</span>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="relative">
                        <select name="category" class="appearance-none pl-3 pr-8 py-1 bg-transparent hover:bg-gray-200/50 rounded-lg text-xs font-bold text-gray-600 cursor-pointer transition-colors border-none focus:ring-0">
                            <option value="">Select Category</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Product">Product</option>
                            <option value="Design">Design</option>
                            <option value="Culture">Culture</option>
                            <option value="Policy">Policy</option>
                        </select>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="w-px h-4 bg-gray-200"></div>

                    <!-- Tags Input -->
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <input type="text" name="tags" placeholder="Add tags..." class="bg-transparent border-none focus:ring-0 p-0 text-xs font-medium text-gray-600 placeholder-gray-400 w-32">
                    </div>
                </div>

                <!-- Editor -->
                <div class="prose prose-lg prose-slate max-w-none focus-within:prose-blue">
                    <textarea name="content" 
                            class="w-full min-h-[50vh] resize-none border-none outline-none focus:ring-0 p-0 text-gray-700 text-lg leading-relaxed placeholder-gray-300 bg-transparent font-serif"
                            placeholder="Start writing your story..." required>{{ old('content') }}</textarea>
                </div>
                
                @error('content') <p class="text-red-500 text-sm mt-4 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Floating Action Bar -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2 p-1.5 bg-slate-900/90 backdrop-blur-xl border border-white/10 rounded-full shadow-2xl z-50 transition-transform hover:-translate-y-1 ring-1 ring-white/20">
            <button type="submit" name="is_published" value="0" class="px-5 py-2.5 rounded-full text-xs font-bold text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                Save Draft
            </button>
            <div class="w-px h-4 bg-white/20"></div>
            <button type="submit" name="is_published" value="1" class="px-6 py-2.5 rounded-full bg-white text-black text-xs font-bold shadow-lg hover:bg-gray-100 transition-all flex items-center gap-2">
                <span>Publish</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

    </form>
</div>

<style>
    /* Custom Scrollbar for Textarea */
    textarea::-webkit-scrollbar { width: 0px; background: transparent; }
</style>
@endsection
