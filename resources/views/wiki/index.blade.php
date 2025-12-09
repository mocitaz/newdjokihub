@extends('layouts.app')

@section('title', 'Knowledge Hub')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20 font-sans">
    
    <!-- Premium Hero Section -->
    <div class="relative bg-gray-900 overflow-hidden isolate">
        <!-- Mesh Gradients -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#06b6d4] to-[#3b82f6] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <!-- Hero Content -->
        <div class="mx-auto max-w-7xl px-6 lg:px-8 pt-24 pb-32 text-center relative z-10">
            <div class="mx-auto max-w-2xl">
                <div class="mb-8 flex justify-center">
                    <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-400 ring-1 ring-white/10 hover:ring-white/20 transition-all bg-white/5 backdrop-blur-sm">
                        The Brain of DjokiHub. <a href="#" class="font-semibold text-white"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-7xl font-display leading-tight mb-6">
                    Knowledge Hub
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-300 font-light mb-10">
                    Discover insights, guides, and documentation to help you build better and faster.
                </p>
                
                <!-- Glass Search Bar -->
                <form action="{{ route('wiki.index') }}" method="GET" class="relative max-w-xl mx-auto group">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="relative flex items-center bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-2 shadow-2xl transition-all group-focus-within:bg-white/20">
                         <svg class="w-6 h-6 text-gray-400 ml-3 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                         <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for anything..." class="w-full bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 px-4 py-3 text-lg font-medium">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Filters -->
    <div class="sticky top-16 z-30 -mt-8 mb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-center gap-2 p-2 rounded-full bg-white/70 backdrop-blur-xl border border-white/40 shadow-xl max-w-fit mx-auto">
                {{-- All Filter --}}
                <a href="{{ route('wiki.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ !request('category') ? 'bg-black text-white shadow-lg scale-105' : 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                   All
                </a>
                
                {{-- Dynamic Filters --}}
                @foreach(['Engineering', 'Product', 'Design', 'Culture', 'Policy'] as $cat)
                <a href="{{ route('wiki.index', ['category' => $cat]) }}" 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request('category') == $cat ? 'bg-black text-white shadow-lg scale-105' : 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                   {{ $cat }}
                </a>
                @endforeach

                {{-- Admin Write Button --}}
                @if(auth()->user()->isAdmin())
                <div class="pl-2 ml-2 border-l border-gray-200">
                    <a href="{{ route('wiki.create') }}" class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 hover:scale-110 transition-all shadow-lg shadow-blue-500/30" title="Write New Article">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($articles->count() > 0)
        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[minmax(300px,auto)]">
            
            @foreach($articles as $index => $article)
            {{-- Feature First Article --}}
            @if($index === 0 && !request('page') || request('page') == 1 && $index === 0)
            <div class="md:col-span-2 md:row-span-2 group relative overflow-hidden rounded-3xl bg-white border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 isolate">
                <a href="{{ route('wiki.show', $article->slug) }}" class="absolute inset-0">
                    <!-- Background Image -->
                    <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-105">
                         @if($article->cover_image)
                            <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                    </div>
                </a>

                <div class="absolute bottom-0 p-8 z-10 w-full">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-lg bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-bold uppercase tracking-wider">
                            Featured
                        </span>
                        @if($article->category)
                        <span class="px-3 py-1 rounded-lg bg-black/40 backdrop-blur-md border border-white/10 text-white text-xs font-bold uppercase tracking-wider">
                            {{ $article->category }}
                        </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('wiki.show', $article->slug) }}"><h2 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight group-hover:text-blue-200 transition-colors font-display">{{ $article->title }}</h2></a>
                    
                    <p class="text-lg text-gray-200 line-clamp-2 max-w-2xl mb-6 font-light">
                        {{ Str::limit(strip_tags($article->content), 150) }}
                    </p>
                    
                    <div class="flex items-center gap-4 text-white/80">
                         <div class="flex items-center gap-2">
                             <img class="w-8 h-8 rounded-full border border-white/20" src="{{ $article->creator->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($article->creator->name) }}" alt="">
                             <span class="text-sm font-bold">{{ $article->creator->name }}</span>
                         </div>
                         <span class="text-white/40">&bull;</span>
                         <span class="text-sm">{{ $article->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            
            @else
            {{-- Standard Cards --}}
            <a href="{{ route('wiki.show', $article->slug) }}" class="group relative flex flex-col overflow-hidden rounded-3xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="h-48 relative overflow-hidden bg-gray-100">
                     @if($article->cover_image)
                        <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="h-full w-full bg-gradient-to-tr from-gray-200 to-gray-100 group-hover:from-blue-50 group-hover:to-purple-50 transition-colors"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-gray-300 group-hover:text-blue-300 transition-colors">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <div class="absolute top-4 right-4">
                        @if($article->category)
                        <span class="px-2 py-1 bg-white/90 backdrop-blur text-gray-900 text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                            {{ $article->category }}
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex-1 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>
                    <p class="text-sm text-gray-500 line-clamp-3 mb-4 leading-relaxed">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                    
                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-xs font-bold text-gray-400">{{ $article->created_at->format('M d') }}</span>
                        <div class="flex items-center gap-1.5">
                             <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                {{ substr($article->creator->name, 0, 1) }}
                            </div>
                            <span class="text-xs text-gray-600 font-medium truncate max-w-[80px]">{{ explode(' ', $article->creator->name)[0] }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>

        @if($articles->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-24">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                 <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-20"></div>
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Knowledge Base is Empty</h3>
            <p class="text-gray-500 max-w-sm mx-auto mb-8">It seems we haven't documented anything here yet. Why not start the first chapter?</p>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('wiki.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white font-bold rounded-xl hover:scale-105 transition-transform shadow-xl shadow-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Write First Article
            </a>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
