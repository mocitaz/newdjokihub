@extends('layouts.app')

@section('title', 'Edit Story')

@section('content')
<div class="min-h-screen bg-white" x-data="{
    imagePreview: '{{ $wiki->cover_image_url }}',
    handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}">
    <form method="POST" action="{{ route('wiki.update', $wiki->slug) }}" enctype="multipart/form-data" class="h-full">
        @csrf
        @method('PUT')
        
        <!-- Sticky Editor Header -->
        <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('wiki.show', $wiki->slug) }}" class="text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <p class="text-sm font-bold text-gray-500">Editing <span class="text-gray-900">{{ Str::limit($wiki->title, 30) }}</span></p>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-100">Draft</span>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('wiki.show', $wiki->slug) }}" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 text-sm">
                    Update Story
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 py-12 px-4 sm:px-6 lg:px-8">
            
            <!-- Main Content Editor (8 Cols) -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Title Input -->
                <div class="group relative">
                    <input type="text" name="title" value="{{ old('title', $wiki->title) }}" 
                           placeholder="Title" 
                           class="w-full text-5xl font-bold text-gray-900 placeholder-gray-300 border-none outline-none focus:ring-0 px-0 py-4 bg-transparent font-display"
                           required>
                    <div class="h-1 w-20 bg-gray-100 group-focus-within:bg-blue-600 transition-colors duration-500 rounded-full"></div>
                    @error('title') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Content Area -->
                <div class="min-h-[500px]">
                    <textarea name="content" 
                              placeholder="Tell your story..." 
                              class="w-full h-[70vh] resize-none text-xl leading-relaxed text-gray-600 placeholder-gray-300 border-none outline-none focus:ring-0 px-0 bg-transparent"
                              required>{{ old('content', $wiki->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Sidebar Metadata (4 Cols) -->
            <div class="lg:col-span-4 space-y-8 pt-6">
                
                <!-- Publishing Settings -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Story Settings</h3>
                    
                    <div class="space-y-4">
                        <!-- Cover Image -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Cover Image</label>
                            <div class="relative group">
                                <div class="w-full h-32 bg-white border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center text-gray-400 group-hover:border-blue-500 group-hover:text-blue-500 transition-colors cursor-pointer overflow-hidden relative"
                                     :style="imagePreview ? `background-image: url('${imagePreview}'); background-size: cover; background-position: center;` : ''">
                                    
                                    <div x-show="!imagePreview" class="flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold uppercase">Change Cover</span>
                                    </div>
                                   
                                    <input type="file" name="cover_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="handleFileUpload($event)">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Category</label>
                            <div class="relative">
                                <select name="category" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium appearance-none">
                                    <option value="">Select a topic...</option>
                                    @foreach(['Engineering', 'Product', 'Design', 'Culture', 'Policy'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $wiki->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags', $wiki->tags ? implode(', ', $wiki->tags) : '') }}" 
                                   placeholder="e.g. guide, setup, v1" 
                                   class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-black outline-none font-medium text-sm">
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <label class="text-sm font-bold text-gray-900">Publish Status</label>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500">Draft</span>
                                <button type="button" 
                                        onclick="document.getElementById('is_published').value = this.getAttribute('aria-checked') === 'true' ? '0' : '1'; this.setAttribute('aria-checked', this.getAttribute('aria-checked') === 'true' ? 'false' : 'true'); this.classList.toggle('bg-green-500'); this.classList.toggle('bg-gray-200'); this.firstElementChild.classList.toggle('translate-x-5');"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ old('is_published', $wiki->is_published) ? 'bg-green-500' : 'bg-gray-200' }}" 
                                        role="switch" 
                                        aria-checked="{{ old('is_published', $wiki->is_published) ? 'true' : 'false' }}">
                                    <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ old('is_published', $wiki->is_published) ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                                <input type="hidden" name="is_published" id="is_published" value="{{ old('is_published', $wiki->is_published) ? '1' : '0' }}">
                                <span class="text-xs text-gray-500">Public</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
