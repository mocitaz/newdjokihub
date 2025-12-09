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
        
        // If it's the old path (logos/...), prefix it with assets/
        if (str_starts_with($value, 'logos/')) {
            return 'assets/' . $value;
        }
        
        return $value;
    }
}
