<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id',
        'campus_id',
        'name',
        'category',
        'food_type',
        'image',
        'description',
        'address',
        'open_hours',
        'price_range',
        'gmaps_link',
        'latitude',
        'longitude',
        'landmark',
        'landmark_photo',
        'status',
    ];

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    // ── Scopes ──

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // ── Accessors ──

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
