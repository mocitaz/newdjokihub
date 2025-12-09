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
}
