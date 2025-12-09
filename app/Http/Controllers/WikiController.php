<?php

namespace App\Http\Controllers;

use App\Models\WikiArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WikiArticle::where('is_published', true)
            ->with('creator');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = WikiArticle::where('is_published', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('wiki.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wiki.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        $tags = !empty($validated['tags']) ? explode(',', $validated['tags']) : [];

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = 'wiki_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('assets/wiki-covers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $coverImagePath = 'assets/wiki-covers/' . $filename;
        }

        WikiArticle::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'category' => $validated['category'] ?? null,
            'tags' => $tags,
            'cover_image' => $coverImagePath,
            'created_by' => auth()->id(),
            'is_published' => $validated['is_published'] ?? true,
        ]);

        return redirect()->route('wiki.index')
            ->with('success', 'Wiki article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($wiki)
    {
        $article = WikiArticle::where('slug', $wiki)->orWhere('id', $wiki)->firstOrFail();
        
        if (!$article->is_published && !auth()->user()->isAdmin()) {
            abort(404);
        }

        $article->incrementViews();
        $article->load(['creator', 'updater']);

        return view('wiki.show', ['wiki' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($wiki)
    {
        $article = WikiArticle::where('slug', $wiki)->orWhere('id', $wiki)->firstOrFail();
        return view('wiki.edit', ['wiki' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $wiki)
    {
        $article = WikiArticle::where('slug', $wiki)->orWhere('id', $wiki)->firstOrFail();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        $tags = !empty($validated['tags']) ? explode(',', $validated['tags']) : [];

        $coverImagePath = $article->cover_image;
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($article->cover_image) {
                // Handle legacy paths just in case, or new assets paths
                $oldPath = public_path($article->cover_image); 
                // If path doesn't start with assets/ but is in DB, try prefixing (legacy support)
                if (!str_contains($article->cover_image, 'assets/')) {
                    $oldPath = public_path('assets/' . $article->cover_image);
                }
                
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            $file = $request->file('cover_image');
            $filename = 'wiki_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('assets/wiki-covers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $coverImagePath = 'assets/wiki-covers/' . $filename;
        }

        $article->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'category' => $validated['category'] ?? null,
            'tags' => $tags,
            'cover_image' => $coverImagePath,
            'updated_by' => auth()->id(),
            'is_published' => $validated['is_published'] ?? $article->is_published,
        ]);

        return redirect()->route('wiki.show', $article->slug)
            ->with('success', 'Wiki article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($wiki)
    {
        $article = WikiArticle::where('slug', $wiki)->orWhere('id', $wiki)->firstOrFail();
        $article->delete();

        return redirect()->route('wiki.index')
            ->with('success', 'Wiki article deleted successfully!');
    }
}
