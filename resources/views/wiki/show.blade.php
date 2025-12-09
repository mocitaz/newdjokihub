@extends('layouts.app')

@section('title', $wiki->title)

@section('content')
<div class="min-h-screen bg-white pb-20 font-sans" x-data="{ 
    showToast: false,
    copyLink() {
        navigator.clipboard.writeText(window.location.href);
        this.showToast = true;
        setTimeout(() => this.showToast = false, 3000);
    }
}">
    
    <!-- Breadcrumbs & Actions Bar -->
    <div class="sticky top-16 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <nav class="flex items-center text-sm font-medium text-gray-500">
                <a href="{{ route('wiki.index') }}" class="hover:text-gray-900 transition-colors">Wiki</a>
                <svg class="h-5 w-5 text-gray-300 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                @if($wiki->category)
                <a href="{{ route('wiki.index', ['category' => $wiki->category]) }}" class="hover:text-gray-900 transition-colors">{{ $wiki->category }}</a>
                <svg class="h-5 w-5 text-gray-300 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                @endif
                <span class="text-gray-900 font-semibold truncate max-w-[200px]">{{ $wiki->title }}</span>
            </nav>

            <div class="flex items-center gap-2">
                 @if(auth()->user()->isAdmin())
                 <a href="{{ route('wiki.edit', $wiki->slug) }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Edit Article">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('wiki.destroy', $wiki->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete Article">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
                <div class="h-4 w-px bg-gray-200 mx-2"></div>
                @endif
                
                <button @click="copyLink()" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Copy Link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Sidebar (Metadata & TOC Placeholder) -->
            <div class="hidden lg:block lg:col-span-3">
                <div class="sticky top-40 space-y-8">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Author</h4>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-600">
                                {{ substr($wiki->creator->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $wiki->creator->name }}</p>
                                <p class="text-xs text-gray-500">{{ $wiki->creator->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                         <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Details</h4>
                         <dl class="space-y-2 text-sm">
                             <div class="flex justify-between">
                                 <dt class="text-gray-500">Published</dt>
                                 <dd class="font-medium text-gray-900">{{ $wiki->created_at->format('M d, Y') }}</dd>
                             </div>
                             <div class="flex justify-between">
                                 <dt class="text-gray-500">Read Time</dt>
                                 <dd class="font-medium text-gray-900">{{ ceil(str_word_count(strip_tags($wiki->content))/200) }} min</dd>
                             </div>
                             <div class="flex justify-between">
                                 <dt class="text-gray-500">Views</dt>
                                 <dd class="font-medium text-gray-900">{{ number_format($wiki->views) }}</dd>
                             </div>
                         </dl>
                    </div>

                    @if($wiki->tags && count($wiki->tags) > 0)
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Tags</h4>
                        <div class="flex flex-wrap gap-2">
                             @foreach($wiki->tags as $tag)
                            <span class="px-2 py-1 bg-gray-50 text-gray-500 rounded text-xs font-medium border border-gray-100">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Main Content (Editorial Style) -->
            <div class="lg:col-span-7">
                <article class="prose prose-lg prose-slate max-w-none">
                    <header class="mb-10 text-center lg:text-left">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight font-display mb-6 leading-tight">
                            {{ $wiki->title }}
                        </h1>
                        
                         @if($wiki->cover_image)
                        <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100 mb-10 w-full aspect-video relative">
                            <img src="{{ Storage::url($wiki->cover_image) }}" alt="{{ $wiki->title }}" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        @endif
                    </header>

                    <div class="prose-headings:font-display prose-headings:font-bold prose-headings:tracking-tight prose-a:text-blue-600 prose-img:rounded-xl prose-img:shadow-lg">
                        {!! nl2br(e($wiki->content)) !!}
                    </div>
                </article>
                
                 <!-- Mobile Metadata (Visible only on small screens) -->
                <div class="lg:hidden mt-12 pt-8 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-600">
                                {{ substr($wiki->creator->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $wiki->creator->name }}</p>
                                <p class="text-xs text-gray-500">{{ $wiki->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                     @if($wiki->tags && count($wiki->tags) > 0)
                    <div class="flex flex-wrap gap-2">
                            @foreach($wiki->tags as $tag)
                        <span class="px-2 py-1 bg-gray-50 text-gray-500 rounded text-xs font-medium border border-gray-100">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Right Spacer / Potential Future TOC -->
            <div class="hidden lg:block lg:col-span-2"></div>
        </div>
    </div>
    <!-- Toast Notification -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-6 right-6 z-50 pointer-events-none">
        <div class="bg-gray-900/90 backdrop-blur-md text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-white/10">
            <div class="bg-green-500/20 text-green-400 p-1.5 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold">Link Copied!</p>
                <p class="text-[10px] text-gray-400 font-medium">Ready to share.</p>
            </div>
        </div>
    </div>
</div>
@endsection
