<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name',
        'acronym',
        'type',
        'city',
        'province',
        'logo_url',
        'website',
    ];
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

        // 2. Normalize path to assets/ (Handle legacy logos/ prefix)
        $path = $value;
        if (str_starts_with($path, 'logos/')) {
            $path = 'assets/' . $path;
        } elseif (!str_contains($path, 'assets/')) {
             // Fallback if just filename
            $path = 'assets/logos/universities/' . $path; // Best guess default
        }

        // 3. Check existence to prevent 404
        if (file_exists(public_path($path))) {
            return asset($path);
        }
        
        return null;
    }
}
