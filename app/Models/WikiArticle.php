<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WikiArticle extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'tags',
        'created_by',
        'updated_by',
        'views',
        'is_published',
        'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the user who created this article
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this article
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Increment views
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get cover image URL
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            // 1. If it's already a full URL or explicit asset path
            if (str_contains($this->cover_image, 'assets/') || str_starts_with($this->cover_image, 'http')) {
                return asset($this->cover_image);
            }
            
            // 2. Legacy: Prefix with assets/
            return asset('assets/' . $this->cover_image);
        }
        
        return null;
    }
}
