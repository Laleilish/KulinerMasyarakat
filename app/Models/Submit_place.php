<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submit_place extends Model
{
    //
    protected $fillable = [
        'user_id', 'campus_id', 'name', 'address',
        'latitude', 'longitude', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
