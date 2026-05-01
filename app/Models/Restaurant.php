<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //
    protected $fillable = [
        'user_id', 'campus_id', 'name', 'address',
        'latitude', 'longitude', 'image', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    // Scope: hanya restoran yang sudah diapproved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
