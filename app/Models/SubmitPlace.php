<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitPlace extends Model
{
    protected $table = 'submit_places';

    protected $fillable = [
        'user_id',
        'campus_id',
        'name',
        'category',
        'food_type',
        'photo',
        'description',
        'address',
        'open_hours',
        'price_range',
        'gmaps_link',
        'latitude',
        'longitude',
        'landmark',
        'landmark_photo',
        'initial_rating',
        'initial_review',
        'initial_review_photos',
        'status',
    ];

    protected $casts = [
        'initial_review_photos' => 'array',
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

    // ── Scopes ──

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
