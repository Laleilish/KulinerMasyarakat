<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'rating',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campus(): BelongsTo
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function scopeTanggalTua($query)
    {
        // Tampilkan restoran yang harga MAKSIMUM-nya tidak melebihi 15.000
        // Ekstrak angka terakhir dari string price_range (contoh: "Rp 10.000 - Rp 15.000" → 15000)
        return $query->whereRaw(
            "CAST(REPLACE(REPLACE(SUBSTRING_INDEX(price_range, 'Rp ', -1), '.', ''), ' ', '') AS UNSIGNED) <= 15000"
        );
    }
}