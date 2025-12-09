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
        
        // If it's the old path (logos/...), prefix it with assets/
        if (str_starts_with($value, 'logos/')) {
            return 'assets/' . $value;
        }
        
        return $value;
    }
}
