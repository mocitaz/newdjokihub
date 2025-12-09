<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'code',
        'logo_url',
        'swift_code',
        'is_active',
    ];

    // No accessor - use raw value and handle in view
    /**
     * Get the logo URL with path migration
     */
    public function getLogoUrlAttribute($value)
    {
        if (!$value) return null;
        
        // 1. If it's a full URL, return as is
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // 2. Normalize path to assets/
        $path = $value;
        if (str_starts_with($path, 'logos/')) {
            $path = 'assets/' . $path;
        } elseif (!str_contains($path, 'assets/')) {
             // Fallback if just filename
            $path = 'assets/logos/banks/' . $path; 
        }

        // 3. Check existence to prevent 404
        if (file_exists(public_path($path))) {
            return asset($path);
        }
        
        return null;
    }
}
