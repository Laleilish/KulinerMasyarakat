<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    protected $fillable = [
        'campus_id', 'name', 'image', 'description',
        'latitude', 'longitude', 'rating', 'distance',
        'price_range', 'category', 'is_featured',
    ];

    protected $casts = [
        'latitude'    => 'float',
        'longitude'   => 'float',
        'rating'      => 'float',
        'is_featured' => 'boolean',
    ];

    // Scope featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }
}