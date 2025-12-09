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
}
